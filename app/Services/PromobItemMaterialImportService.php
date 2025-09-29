<?php

namespace App\Services;

use App\Models\ItemProjeto;
use App\Models\MaterialItemProjeto;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;
use SimpleXMLElement;

class PromobItemMaterialImportService
{
    /**
     * Importa materiais de um arquivo XML do Promob para um item específico
     */
    public function importarMateriaisParaItem(ItemProjeto $item, UploadedFile $arquivo): array
    {
        DB::beginTransaction();
        
        try {
            // Validar se o arquivo é XML
            if ($arquivo->getClientOriginalExtension() !== 'xml') {
                throw new Exception('Arquivo deve ter extensão .xml');
            }

            // Ler o conteúdo do arquivo
            $xmlContent = file_get_contents($arquivo->getPathname());
            if (!$xmlContent) {
                throw new Exception('Não foi possível ler o conteúdo do arquivo XML');
            }

            // Validar e parsear XML
            libxml_use_internal_errors(true);
            $xml = new SimpleXMLElement($xmlContent);
            
            Log::info('XML parseado com sucesso', [
                'item_projeto_id' => $item->id,
                'xml_root' => $xml->getName(),
                'has_ambients' => isset($xml->AMBIENTS),
                'ambients_count' => isset($xml->AMBIENTS) ? count($xml->AMBIENTS->AMBIENT) : 0
            ]);
            
            // Validar estrutura básica do XML do Promob
            if (!isset($xml->AMBIENTS)) {
                throw new Exception('Arquivo XML não possui a estrutura esperada do Promob (AMBIENTS não encontrado)');
            }

            $resultado = [
                'sucesso' => 0,
                'erros' => 0,
                'detalhes' => [],
                'materiais_importados' => []
            ];

            // Processar cada ambiente
            foreach ($xml->AMBIENTS->AMBIENT as $ambiente) {
                $resultadoAmbiente = $this->processarAmbienteParaItem($item, $ambiente, $arquivo->getClientOriginalName(), $xmlContent);
                
                $resultado['sucesso'] += $resultadoAmbiente['sucesso'];
                $resultado['erros'] += $resultadoAmbiente['erros'];
                $resultado['detalhes'] = array_merge($resultado['detalhes'], $resultadoAmbiente['detalhes']);
                $resultado['materiais_importados'] = array_merge($resultado['materiais_importados'], $resultadoAmbiente['materiais_importados']);
            }

            DB::commit();
            
            Log::info('Importação de materiais para item concluída', [
                'item_projeto_id' => $item->id,
                'arquivo' => $arquivo->getClientOriginalName(),
                'materiais_importados' => $resultado['sucesso'],
                'erros' => $resultado['erros']
            ]);

            return $resultado;

        } catch (Exception $e) {
            DB::rollBack();
            
            Log::error('Erro na importação de materiais para item', [
                'item_projeto_id' => $item->id,
                'arquivo' => $arquivo->getClientOriginalName(),
                'erro' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    /**
     * Processa um ambiente do XML para um item específico
     */
    private function processarAmbienteParaItem(ItemProjeto $item, SimpleXMLElement $ambiente, string $nomeArquivo, string $xmlContent): array
    {
        $resultado = [
            'sucesso' => 0,
            'erros' => 0,
            'detalhes' => [],
            'materiais_importados' => []
        ];

        // Obter informações do ambiente
        $descricaoAmbiente = (string)$ambiente['DESCRIPTION'] ?? 'Ambiente';
        $guidAmbiente = (string)$ambiente['GUID'] ?? null;

        Log::info('Processando ambiente', [
            'item_projeto_id' => $item->id,
            'ambiente_descricao' => $descricaoAmbiente,
            'has_categories' => isset($ambiente->CATEGORIES),
            'categories_count' => isset($ambiente->CATEGORIES) ? count($ambiente->CATEGORIES->CATEGORY) : 0
        ]);

        // Processar categorias
        if (isset($ambiente->CATEGORIES)) {
            foreach ($ambiente->CATEGORIES->CATEGORY as $categoria) {
                $resultadoCategoria = $this->processarCategoriaParaItem(
                    $item, 
                    $categoria, 
                    $descricaoAmbiente, 
                    $nomeArquivo,
                    $xmlContent
                );
                
                $resultado['sucesso'] += $resultadoCategoria['sucesso'];
                $resultado['erros'] += $resultadoCategoria['erros'];
                $resultado['detalhes'] = array_merge($resultado['detalhes'], $resultadoCategoria['detalhes']);
                $resultado['materiais_importados'] = array_merge($resultado['materiais_importados'], $resultadoCategoria['materiais_importados']);
            }
        }

        return $resultado;
    }

    /**
     * Processa uma categoria do XML para um item específico
     */
    private function processarCategoriaParaItem(ItemProjeto $item, SimpleXMLElement $categoria, string $descricaoAmbiente, string $nomeArquivo, string $xmlContent): array
    {
        $resultado = [
            'sucesso' => 0,
            'erros' => 0,
            'detalhes' => [],
            'materiais_importados' => []
        ];

        $nomeCategoria = (string)$categoria['DESCRIPTION'] ?? 'Sem categoria';

        Log::info('Processando categoria', [
            'item_projeto_id' => $item->id,
            'categoria_nome' => $nomeCategoria,
            'has_items' => isset($categoria->ITEMS),
            'items_count' => isset($categoria->ITEMS) ? count($categoria->ITEMS->ITEM) : 0
        ]);

        // Processar itens da categoria
        if (isset($categoria->ITEMS)) {
            foreach ($categoria->ITEMS->ITEM as $xmlItem) {
                try {
                    // Verificar se é um item que contém subitens (materiais)
                    $materialCriado = $this->processarMaterialDoItem(
                        $item, 
                        $xmlItem, 
                        $nomeCategoria, 
                        $descricaoAmbiente, 
                        $nomeArquivo,
                        $xmlContent
                    );
                    
                    if ($materialCriado) {
                        $resultado['sucesso']++;
                        $resultado['materiais_importados'][] = $materialCriado;
                        $resultado['detalhes'][] = "Material '{$materialCriado->descricao}' importado com sucesso";
                    }

                    // Processar subitens se existirem
                    if (isset($xmlItem->ITEMS)) {
                        foreach ($xmlItem->ITEMS->ITEM as $subItem) {
                            try {
                                $subMaterialCriado = $this->processarMaterialDoItem(
                                    $item, 
                                    $subItem, 
                                    $nomeCategoria, 
                                    $descricaoAmbiente, 
                                    $nomeArquivo,
                                    $xmlContent
                                );
                                
                                if ($subMaterialCriado) {
                                    $resultado['sucesso']++;
                                    $resultado['materiais_importados'][] = $subMaterialCriado;
                                    $resultado['detalhes'][] = "Sub-material '{$subMaterialCriado->descricao}' importado com sucesso";
                                }
                            } catch (Exception $e) {
                                $resultado['erros']++;
                                $descricaoSubItem = (string)$subItem['DESCRIPTION'] ?? 'Sub-item sem descrição';
                                $resultado['detalhes'][] = "Erro ao processar sub-material '{$descricaoSubItem}': " . $e->getMessage();
                            }
                        }
                    }

                } catch (Exception $e) {
                    $resultado['erros']++;
                    $descricaoItem = (string)$xmlItem['DESCRIPTION'] ?? 'Item sem descrição';
                    $resultado['detalhes'][] = "Erro ao processar material '{$descricaoItem}': " . $e->getMessage();
                    
                    Log::warning('Erro ao processar material do XML', [
                        'item_projeto_id' => $item->id,
                        'material_description' => $descricaoItem,
                        'erro' => $e->getMessage()
                    ]);
                }
            }
        }

        return $resultado;
    }

    /**
     * Processa um material individual do XML
     */
    private function processarMaterialDoItem(ItemProjeto $item, SimpleXMLElement $xmlItem, string $categoria, string $ambiente, string $nomeArquivo, string $xmlContent): ?MaterialItemProjeto
    {
        // Extrair dados do material
        $dadosMaterial = $this->extrairDadosMaterial($xmlItem, $categoria, $ambiente);
        
        // Verificar se material já existe (baseado no GUID + item)
        if ($dadosMaterial['guid']) {
            $materialExistente = MaterialItemProjeto::where('item_projeto_id', $item->id)
                ->where('guid', $dadosMaterial['guid'])
                ->first();
                
            if ($materialExistente) {
                // Atualizar dados do material existente
                $this->atualizarMaterialExistente($materialExistente, $dadosMaterial, $nomeArquivo, $xmlContent);
                return $materialExistente;
            }
        }

        // Criar novo material
        return $this->criarNovoMaterial($item, $dadosMaterial, $nomeArquivo, $xmlContent);
    }

    /**
     * Extrai dados de um material do XML
     */
    private function extrairDadosMaterial(SimpleXMLElement $xmlItem, string $categoria, string $ambiente): array
    {
        $attributes = $xmlItem->attributes();
        
        return [
            'id_promob' => (string)($attributes['ID'] ?? ''),
            'descricao' => (string)($attributes['DESCRIPTION'] ?? ''),
            'referencia' => (string)($attributes['REFERENCE'] ?? ''),
            'unidade' => (string)($attributes['UNIT'] ?? ''),
            'quantidade' => (float)($attributes['QUANTITY'] ?? 0),
            'repeticao' => (int)($attributes['REPETITION'] ?? 1),
            'largura' => (float)($attributes['WIDTH'] ?? 0),
            'altura' => (float)($attributes['HEIGHT'] ?? 0),
            'profundidade' => (float)($attributes['DEPTH'] ?? 0),
            'dimensoes_texto' => (string)($attributes['TEXTDIMENSION'] ?? ''),
            'familia' => (string)($attributes['FAMILY'] ?? ''),
            'grupo' => (string)($attributes['GROUP'] ?? ''),
            'guid' => (string)($attributes['GUID'] ?? ''),
            'unique_id' => (string)($attributes['UNIQUEID'] ?? ''),
            'categoria' => $categoria,
            'subcategoria' => $ambiente,
            'observacoes' => (string)($attributes['OBSERVATIONS'] ?? ''),
            // Campos específicos do Promob
            'component' => (string)($attributes['COMPONENT'] ?? ''),
            'structure' => (string)($attributes['STRUCTURE'] ?? ''),
        ];
    }

    /**
     * Atualiza um material existente com novos dados
     */
    private function atualizarMaterialExistente(MaterialItemProjeto $material, array $dadosMaterial, string $nomeArquivo, string $xmlContent): void
    {
        $material->update([
            'descricao' => $dadosMaterial['descricao'],
            'referencia' => $dadosMaterial['referencia'],
            'unidade' => $dadosMaterial['unidade'],
            'quantidade' => $dadosMaterial['quantidade'],
            'repeticao' => $dadosMaterial['repeticao'],
            'largura' => $dadosMaterial['largura'],
            'altura' => $dadosMaterial['altura'],
            'profundidade' => $dadosMaterial['profundidade'],
            'dimensoes_texto' => $dadosMaterial['dimensoes_texto'],
            'categoria' => $dadosMaterial['categoria'],
            'subcategoria' => $dadosMaterial['subcategoria'],
            'familia' => $dadosMaterial['familia'],
            'grupo' => $dadosMaterial['grupo'],
            'component' => $dadosMaterial['component'],
            'structure' => $dadosMaterial['structure'],
            'observacoes' => $dadosMaterial['observacoes'],
            'xml_data' => $xmlContent,
            'metadados' => $dadosMaterial,
            'arquivo_xml_nome' => $nomeArquivo,
            'data_importacao' => now(),
            'importado_por' => Auth::id(),
        ]);
    }

    /**
     * Cria um novo material
     */
    private function criarNovoMaterial(ItemProjeto $item, array $dadosMaterial, string $nomeArquivo, string $xmlContent): MaterialItemProjeto
    {
        return MaterialItemProjeto::create([
            'item_projeto_id' => $item->id,
            'id_promob' => $dadosMaterial['id_promob'],
            'descricao' => $dadosMaterial['descricao'] ?: 'Material importado do Promob',
            'referencia' => $dadosMaterial['referencia'],
            'unidade' => $dadosMaterial['unidade'],
            'quantidade' => $dadosMaterial['quantidade'] ?: 0,
            'repeticao' => $dadosMaterial['repeticao'],
            'largura' => $dadosMaterial['largura'],
            'altura' => $dadosMaterial['altura'],
            'profundidade' => $dadosMaterial['profundidade'],
            'dimensoes_texto' => $dadosMaterial['dimensoes_texto'],
            'categoria' => $dadosMaterial['categoria'],
            'subcategoria' => $dadosMaterial['subcategoria'],
            'familia' => $dadosMaterial['familia'],
            'grupo' => $dadosMaterial['grupo'],
            'guid' => $dadosMaterial['guid'],
            'unique_id' => $dadosMaterial['unique_id'],
            'component' => $dadosMaterial['component'],
            'structure' => $dadosMaterial['structure'],
            'observacoes' => $dadosMaterial['observacoes'],
            'xml_data' => $xmlContent,
            'metadados' => $dadosMaterial,
            'arquivo_xml_nome' => $nomeArquivo,
            'data_importacao' => now(),
            'importado_por' => Auth::id(),
        ]);
    }

    /**
     * Remove todos os materiais de um item
     */
    public function limparMateriaisDoItem(ItemProjeto $item): int
    {
        $quantidade = $item->materiaisPromob()->count();
        $item->materiaisPromob()->delete();
        
        Log::info('Materiais do item removidos', [
            'item_projeto_id' => $item->id,
            'quantidade_removida' => $quantidade
        ]);
        
        return $quantidade;
    }

    /**
     * Valida se o XML tem estrutura válida do Promob
     */
    public function validarEstrutura(string $xmlContent): bool
    {
        try {
            $xml = new SimpleXMLElement($xmlContent);
            
            // Verificar elementos obrigatórios
            return isset($xml->AMBIENTS) && 
                   isset($xml->PROJECTGUID) && 
                   isset($xml->ABOUTPROMOB);
                   
        } catch (Exception $e) {
            return false;
        }
    }
}