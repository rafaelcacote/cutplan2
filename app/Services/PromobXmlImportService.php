<?php

namespace App\Services;

use App\Models\ItemProjeto;
use App\Models\Projeto;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;
use SimpleXMLElement;

class PromobXmlImportService
{
    /**
     * Importa materiais de um arquivo XML do Promob para os itens de um projeto
     */
    public function importarArquivo(Projeto $projeto, UploadedFile $arquivo): array
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
            $xml = new SimpleXMLElement($xmlContent);
            
            // Validar estrutura básica do XML do Promob
            if (!isset($xml->AMBIENTS)) {
                throw new Exception('Arquivo XML não possui a estrutura esperada do Promob (AMBIENTS não encontrado)');
            }

            $resultado = [
                'sucesso' => 0,
                'erros' => 0,
                'detalhes' => [],
                'itens_processados' => []
            ];

            // Processar cada ambiente
            foreach ($xml->AMBIENTS->AMBIENT as $ambiente) {
                $resultadoAmbiente = $this->processarAmbiente($projeto, $ambiente, $xmlContent);
                
                $resultado['sucesso'] += $resultadoAmbiente['sucesso'];
                $resultado['erros'] += $resultadoAmbiente['erros'];
                $resultado['detalhes'] = array_merge($resultado['detalhes'], $resultadoAmbiente['detalhes']);
                $resultado['itens_processados'] = array_merge($resultado['itens_processados'], $resultadoAmbiente['itens_processados']);
            }

            DB::commit();
            
            Log::info('Importação XML Promob concluída', [
                'projeto_id' => $projeto->id,
                'arquivo' => $arquivo->getClientOriginalName(),
                'sucesso' => $resultado['sucesso'],
                'erros' => $resultado['erros']
            ]);

            return $resultado;

        } catch (Exception $e) {
            DB::rollBack();
            
            Log::error('Erro na importação XML Promob', [
                'projeto_id' => $projeto->id,
                'arquivo' => $arquivo->getClientOriginalName(),
                'erro' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    /**
     * Processa um ambiente do XML
     */
    private function processarAmbiente(Projeto $projeto, SimpleXMLElement $ambiente, string $xmlContent): array
    {
        $resultado = [
            'sucesso' => 0,
            'erros' => 0,
            'detalhes' => [],
            'itens_processados' => []
        ];

        // Obter informações do ambiente
        $descricaoAmbiente = (string)$ambiente['DESCRIPTION'] ?? 'Ambiente';
        $guidAmbiente = (string)$ambiente['GUID'] ?? null;

        // Processar categorias
        if (isset($ambiente->CATEGORIES)) {
            foreach ($ambiente->CATEGORIES->CATEGORY as $categoria) {
                $resultadoCategoria = $this->processarCategoria(
                    $projeto, 
                    $categoria, 
                    $descricaoAmbiente, 
                    $guidAmbiente, 
                    $xmlContent
                );
                
                $resultado['sucesso'] += $resultadoCategoria['sucesso'];
                $resultado['erros'] += $resultadoCategoria['erros'];
                $resultado['detalhes'] = array_merge($resultado['detalhes'], $resultadoCategoria['detalhes']);
                $resultado['itens_processados'] = array_merge($resultado['itens_processados'], $resultadoCategoria['itens_processados']);
            }
        }

        return $resultado;
    }

    /**
     * Processa uma categoria do XML
     */
    private function processarCategoria(Projeto $projeto, SimpleXMLElement $categoria, string $descricaoAmbiente, ?string $guidAmbiente, string $xmlContent): array
    {
        $resultado = [
            'sucesso' => 0,
            'erros' => 0,
            'detalhes' => [],
            'itens_processados' => []
        ];

        $nomeCategoria = (string)$categoria['DESCRIPTION'] ?? 'Sem categoria';

        // Processar itens da categoria
        if (isset($categoria->ITEMS)) {
            foreach ($categoria->ITEMS->ITEM as $item) {
                try {
                    $itemCriado = $this->processarItem(
                        $projeto, 
                        $item, 
                        $nomeCategoria, 
                        $descricaoAmbiente, 
                        $guidAmbiente, 
                        $xmlContent
                    );
                    
                    if ($itemCriado) {
                        $resultado['sucesso']++;
                        $resultado['itens_processados'][] = $itemCriado;
                        $resultado['detalhes'][] = "Item '{$itemCriado->descricao}' importado com sucesso";
                    }

                } catch (Exception $e) {
                    $resultado['erros']++;
                    $descricaoItem = (string)$item['DESCRIPTION'] ?? 'Item sem descrição';
                    $resultado['detalhes'][] = "Erro ao processar item '{$descricaoItem}': " . $e->getMessage();
                    
                    Log::warning('Erro ao processar item do XML', [
                        'projeto_id' => $projeto->id,
                        'item_description' => $descricaoItem,
                        'erro' => $e->getMessage()
                    ]);
                }
            }
        }

        return $resultado;
    }

    /**
     * Processa um item individual do XML
     */
    private function processarItem(Projeto $projeto, SimpleXMLElement $item, string $categoria, string $ambiente, ?string $guidAmbiente, string $xmlContent): ?ItemProjeto
    {
        // Extrair dados do item
        $dadosItem = $this->extrairDadosItem($item, $categoria, $ambiente);
        
        // Verificar se item já existe (baseado no GUID + projeto)
        if ($dadosItem['guid']) {
            $itemExistente = ItemProjeto::where('projeto_id', $projeto->id)
                ->where('guid', $dadosItem['guid'])
                ->first();
                
            if ($itemExistente) {
                // Atualizar dados do item existente
                $this->atualizarItemExistente($itemExistente, $dadosItem, $xmlContent);
                return $itemExistente;
            }
        }

        // Criar novo item
        return $this->criarNovoItem($projeto, $dadosItem, $xmlContent);
    }

    /**
     * Extrai dados de um item XML
     */
    private function extrairDadosItem(SimpleXMLElement $item, string $categoria, string $ambiente): array
    {
        $attributes = $item->attributes();
        
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
            'codigo_promob' => (string)($attributes['UNIQUEID'] ?? ''),
            'categoria' => $categoria,
            'ambiente' => $ambiente,
            'observacao' => (string)($attributes['OBSERVATIONS'] ?? ''),
            // Campos específicos do Promob
            'component' => (string)($attributes['COMPONENT'] ?? ''),
            'structure' => (string)($attributes['STRUCTURE'] ?? ''),
            'image' => (string)($attributes['IMAGE'] ?? ''),
            'inverted' => (string)($attributes['INVERTED'] ?? ''),
        ];
    }

    /**
     * Atualiza um item existente com novos dados
     */
    private function atualizarItemExistente(ItemProjeto $item, array $dadosItem, string $xmlContent): void
    {
        // Atualizar campos permitidos
        $item->update([
            'categoria' => $dadosItem['categoria'],
            'subcategoria' => $dadosItem['ambiente'],
            'referencia' => $dadosItem['referencia'],
            'familia' => $dadosItem['familia'],
            'grupo' => $dadosItem['grupo'],
            'largura' => $dadosItem['largura'],
            'altura' => $dadosItem['altura'],
            'profundidade' => $dadosItem['profundidade'],
            'dimensoes_texto' => $dadosItem['dimensoes_texto'],
            'repeticao' => $dadosItem['repeticao'],
            'quantidade' => $dadosItem['quantidade'],
            'dados_promob_xml' => $xmlContent,
            'metadados_promob' => $dadosItem,
            'data_importacao_xml' => now(),
            'atualizado_por' => Auth::id(),
        ]);
    }

    /**
     * Cria um novo item do projeto
     */
    private function criarNovoItem(Projeto $projeto, array $dadosItem, string $xmlContent): ItemProjeto
    {
        return ItemProjeto::create([
            'projeto_id' => $projeto->id,
            'descricao' => $dadosItem['descricao'] ?: 'Item importado do Promob',
            'observacao' => $dadosItem['observacao'],
            'quantidade' => $dadosItem['quantidade'] ?: 1,
            'codigo_promob' => $dadosItem['codigo_promob'],
            'categoria' => $dadosItem['categoria'],
            'subcategoria' => $dadosItem['ambiente'],
            'referencia' => $dadosItem['referencia'],
            'familia' => $dadosItem['familia'],
            'grupo' => $dadosItem['grupo'],
            'largura' => $dadosItem['largura'],
            'altura' => $dadosItem['altura'],
            'profundidade' => $dadosItem['profundidade'],
            'dimensoes_texto' => $dadosItem['dimensoes_texto'],
            'guid' => $dadosItem['guid'],
            'repeticao' => $dadosItem['repeticao'],
            'dados_promob_xml' => $xmlContent,
            'metadados_promob' => $dadosItem,
            'data_importacao_xml' => now(),
            'status' => 'pendente',
            'criado_por' => Auth::id(),
        ]);
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

    /**
     * Extrai informações do cabeçalho do XML
     */
    public function extrairInformacoesGerais(string $xmlContent): array
    {
        try {
            $xml = new SimpleXMLElement($xmlContent);
            $attributes = $xml->attributes();
            
            $dadosCliente = [];
            if (isset($xml->CUSTOMERSDATA)) {
                foreach ($xml->CUSTOMERSDATA->DATA as $data) {
                    $id = (string)$data['ID'];
                    $value = (string)$data['VALUE'];
                    if ($value) {
                        $dadosCliente[$id] = $value;
                    }
                }
            }
            
            return [
                'customer_number' => (string)($attributes['CUSTOMERNUMBER'] ?? ''),
                'description' => (string)($attributes['DESCRIPTION'] ?? ''),
                'date' => (string)($attributes['DATE'] ?? ''),
                'hour' => (string)($attributes['HOUR'] ?? ''),
                'unit' => (string)($attributes['UNIT'] ?? ''),
                'ambients' => (string)($attributes['AMBIENTS'] ?? ''),
                'project_guid' => isset($xml->PROJECTGUID) ? (string)$xml->PROJECTGUID['GUID'] : null,
                'dados_cliente' => $dadosCliente,
                'sobre_promob' => isset($xml->ABOUTPROMOB) ? [
                    'version' => (string)($xml->ABOUTPROMOB['VERSION'] ?? ''),
                    'system' => (string)($xml->ABOUTPROMOB['SYSTEM'] ?? ''),
                    'customer_number' => (string)($xml->ABOUTPROMOB['CUSTOMERNUMBER'] ?? ''),
                ] : []
            ];
            
        } catch (Exception $e) {
            Log::error('Erro ao extrair informações gerais do XML', ['erro' => $e->getMessage()]);
            return [];
        }
    }
}