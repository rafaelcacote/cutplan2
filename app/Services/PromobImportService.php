<?php

namespace App\Services;

use App\Models\ItemProjeto;
use App\Models\MaterialItemProjeto;
use App\Models\Material;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PromobImportService
{
    /**
     * Processa um arquivo XML do Promob e importa os materiais para um item de projeto
     */
    public function importarMateriaisDoXml($xmlContent, $itemProjetoId)
    {
        try {
            DB::beginTransaction();

            // Verificar se o item do projeto existe
            $itemProjeto = ItemProjeto::findOrFail($itemProjetoId);

            // Carregar e validar o XML
            $xml = simplexml_load_string($xmlContent);
            if (!$xml) {
                throw new \Exception('Arquivo XML inválido');
            }

            // Limpar materiais existentes deste item (apenas os importados)
            MaterialItemProjeto::where('item_projeto_id', $itemProjetoId)
                ->where('origem', 'importacao')
                ->delete();

            $materiaisImportados = [];
            $contadorImportados = 0;

            // Processar os materiais do XML
            $materiais = $this->extrairMateriaisDoXml($xml);

            foreach ($materiais as $materialData) {
                // Tentar encontrar um material cadastrado que corresponda
                $materialEncontrado = $this->encontrarMaterialCorrespondente($materialData);

                // Criar o registro na tabela materiais_itens_projeto
                $materialItemProjeto = MaterialItemProjeto::create([
                    'item_projeto_id' => $itemProjetoId,
                    'material_id' => $materialEncontrado ? $materialEncontrado->id : null,
                    'codigo_promob' => $materialData['codigo'] ?? null,
                    'descricao' => $materialData['descricao'],
                    'unidade' => $materialData['unidade'] ?? 'UN',
                    'quantidade' => $materialData['quantidade_total'] ?? $materialData['quantidade'],
                    'largura' => $materialData['largura'] ?? null,
                    'altura' => $materialData['altura'] ?? null,
                    'profundidade' => $materialData['profundidade'] ?? null,
                    'familia' => $materialData['familia'] ?? null,
                    'grupo' => $materialData['grupo'] ?? null,
                    'imagem' => $materialData['imagem'] ?? null,
                    'origem' => 'importacao',
                ]);

                $materiaisImportados[] = $materialItemProjeto;
                $contadorImportados++;
            }

            // Atualizar os dados do item do projeto com informações do XML
            $this->atualizarItemProjetoComDadosXml($itemProjeto, $xml);

            DB::commit();

            Log::info("Importação de materiais concluída", [
                'item_projeto_id' => $itemProjetoId,
                'materiais_importados' => $contadorImportados
            ]);

            return [
                'success' => true,
                'materiais_importados' => $contadorImportados,
                'materiais' => $materiaisImportados,
                'message' => "Importação realizada com sucesso! {$contadorImportados} materiais importados."
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro na importação de materiais do Promob', [
                'error' => $e->getMessage(),
                'item_projeto_id' => $itemProjetoId
            ]);

            return [
                'success' => false,
                'message' => 'Erro na importação: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Extrai os materiais do XML do Promob
     */
    private function extrairMateriaisDoXml($xml)
    {
        $materiais = [];

        // Processar XML do formato real do Promob (LISTING > AMBIENTS > AMBIENT > CATEGORIES > CATEGORY > ITEMS)
        if (isset($xml->AMBIENTS)) {
            foreach ($xml->AMBIENTS->AMBIENT as $ambient) {
                // Verificar se há ITEMS direto no ambiente
                if (isset($ambient->ITEMS)) {
                    $this->processarItensXml($ambient->ITEMS, $materiais);
                }
                
                // Verificar se há CATEGORIES
                if (isset($ambient->CATEGORIES)) {
                    foreach ($ambient->CATEGORIES->CATEGORY as $category) {
                        if (isset($category->ITEMS)) {
                            $this->processarItensXml($category->ITEMS, $materiais);
                        }
                    }
                }
            }
        }

        // Processar também itens diretos se houver
        $this->processarItensXml($xml, $materiais);

        Log::info('Materiais extraídos do XML', ['total' => count($materiais)]);

        return $materiais;
    }

    /**
     * Processa recursivamente os ITEMS do XML do Promob
     */
    private function processarItensXml($xmlNode, &$materiais)
    {
        // Verificar se há elementos ITEM diretamente no nó
        if (isset($xmlNode->ITEM)) {
            foreach ($xmlNode->ITEM as $item) {
                $this->processarItem($item, $materiais);
            }
        }

        // Verificar se o nó atual tem ITEMS como filho
        if (isset($xmlNode->ITEMS)) {
            foreach ($xmlNode->ITEMS->ITEM as $item) {
                $this->processarItem($item, $materiais);
            }
        }
    }

    /**
     * Processa um item individual do XML
     */
    private function processarItem($item, &$materiais)
    {
        $attributes = $item->attributes();
        
        $material = [
            'codigo' => (string) $attributes->REFERENCE ?? (string) $attributes->ID,
            'descricao' => (string) $attributes->DESCRIPTION,
            'unidade' => (string) $attributes->UNIT ?? 'UN',
            'quantidade' => (float) $attributes->QUANTITY ?? 1,
            'repetition' => (int) $attributes->REPETITION ?? 1,
            'largura' => isset($attributes->WIDTH) ? (float) $attributes->WIDTH : null,
            'altura' => isset($attributes->HEIGHT) ? (float) $attributes->HEIGHT : null,
            'profundidade' => isset($attributes->DEPTH) ? (float) $attributes->DEPTH : null,
            'familia' => (string) $attributes->FAMILY ?? null,
            'grupo' => (string) $attributes->GROUP ?? null,
            'imagem' => (string) $attributes->IMAGE ?? null,
            'guid' => (string) $attributes->GUID ?? null,
            'uniqueid' => (string) $attributes->UNIQUEID ?? null,
            'textdimension' => (string) $attributes->TEXTDIMENSION ?? null,
        ];

        // Calcular quantidade total considerando repetição
        $material['quantidade_total'] = $material['quantidade'] * $material['repetition'];

        // Adicionar apenas se não estiver vazio
        if (!empty($material['descricao'])) {
            $materiais[] = $material;
            Log::info('Material processado', ['descricao' => $material['descricao']]);
        }

        // Processar recursivamente os subitens
        $this->processarItensXml($item, $materiais);
    }

        /**
     * Tenta encontrar um material cadastrado que corresponda ao material do XML
     */
    private function encontrarMaterialCorrespondente($materialData)
    {
        // Buscar por código exato (primeiro por REFERENCE, depois por ID)
        if (!empty($materialData['codigo'])) {
            // Tentar buscar assumindo que existe um campo código no material
            // Como vimos que a tabela não tem código, vamos buscar por nome
            $codigo = $materialData['codigo'];
            $material = Material::where('nome', 'LIKE', "%{$codigo}%")->first();
            if ($material) return $material;
        }

        // Buscar por nome/descrição similar
        $descricao = $materialData['descricao'];
        
        // Tentar busca exata primeiro
        $material = Material::where('nome', $descricao)->first();
        if ($material) return $material;

        // Busca por similaridade
        $material = Material::where('nome', 'LIKE', "%{$descricao}%")
            ->first();
        if ($material) return $material;

        // Busca com texto limpo
        $descricaoLimpa = $this->limparTexto($descricao);
        $material = Material::where('nome', 'LIKE', "%{$descricaoLimpa}%")
            ->first();

        return $material;
    }

    /**
     * Atualiza o item do projeto com dados do XML
     */
    private function atualizarItemProjetoComDadosXml($itemProjeto, $xml)
    {
        $dadosXml = [];

        // Extrair informações gerais do XML
        if (isset($xml->Informacoes)) {
            $dadosXml['data_geracao'] = (string) $xml->Informacoes->DataGeracao ?? null;
            $dadosXml['versao_promob'] = (string) $xml->Informacoes->VersaoPromob ?? null;
        }

        // Salvar o XML completo como metadados
        $itemProjeto->update([
            'dados_promob_xml' => $xml->asXML(),
            'metadados_promob' => json_encode($dadosXml),
            'data_importacao_xml' => now(),
        ]);
    }

    /**
     * Remove acentos e caracteres especiais para busca
     */
    private function limparTexto($texto)
    {
        $texto = strtolower($texto);
        $texto = preg_replace('/[áàãâä]/u', 'a', $texto);
        $texto = preg_replace('/[éèêë]/u', 'e', $texto);
        $texto = preg_replace('/[íìîï]/u', 'i', $texto);
        $texto = preg_replace('/[óòõôö]/u', 'o', $texto);
        $texto = preg_replace('/[úùûü]/u', 'u', $texto);
        $texto = preg_replace('/[ç]/u', 'c', $texto);
        $texto = preg_replace('/[^a-z0-9\s]/u', '', $texto);
        
        return $texto;
    }

    /**
     * Retorna uma prévia dos materiais que seriam importados sem salvar
     */
    public function previewImportacao($xmlContent)
    {
        try {
            Log::info('Iniciando preview de importação', ['xml_size' => strlen($xmlContent)]);
            
            $xml = simplexml_load_string($xmlContent);
            if (!$xml) {
                throw new \Exception('Arquivo XML inválido');
            }

            Log::info('XML carregado com sucesso', ['root_element' => $xml->getName()]);

            $materiais = $this->extrairMateriaisDoXml($xml);
            
            Log::info('Materiais extraídos', ['total' => count($materiais)]);

            $preview = [];

            foreach ($materiais as $materialData) {
                $materialEncontrado = $this->encontrarMaterialCorrespondente($materialData);
                
                $preview[] = [
                    'descricao' => $materialData['descricao'],
                    'quantidade' => $materialData['quantidade_total'] ?? $materialData['quantidade'],
                    'quantidade_unitaria' => $materialData['quantidade'],
                    'repetition' => $materialData['repetition'] ?? 1,
                    'unidade' => $materialData['unidade'],
                    'codigo_promob' => $materialData['codigo'],
                    'dimensoes' => $materialData['textdimension'] ?? null,
                    'material_encontrado' => $materialEncontrado ? [
                        'id' => $materialEncontrado->id,
                        'nome' => $materialEncontrado->nome,
                        'preco_custo' => $materialEncontrado->preco_custo
                    ] : null,
                    'status_match' => $materialEncontrado ? 'encontrado' : 'novo'
                ];
            }

            Log::info('Preview gerado com sucesso', ['total_preview' => count($preview)]);

            return [
                'success' => true,
                'total_materiais' => count($materiais),
                'materiais' => $preview
            ];

        } catch (\Exception $e) {
            Log::error('Erro no preview de importação', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Erro ao processar XML: ' . $e->getMessage()
            ];
        }
    }
}