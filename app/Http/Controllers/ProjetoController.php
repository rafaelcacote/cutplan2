<?php

namespace App\Http\Controllers;

use App\Models\Projeto;
use App\Models\Cliente;
use App\Models\User;
use App\Models\Endereco;
use App\Models\Equipe;
use App\Models\Orcamento;
use App\Services\PromobXmlImportService;
use App\Services\PromobItemMaterialImportService;
use App\Models\ItemProjeto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProjetoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Projeto::with(['cliente', 'gerente', 'equipe'])
            ->orderBy('created_at', 'desc');

        // Filtros
        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('data_inicio') && $request->filled('data_fim')) {
            $query->whereBetween('data_inicio', [$request->data_inicio, $request->data_fim]);
        }

        if ($request->filled('gerente_id')) {
            $query->where('gerente_user_id', $request->gerente_id);
        }

        $projetos = $query->paginate(15);

        // Dados para os filtros
        $clientes = Cliente::orderBy('nome')->get();
        $gerentes = User::whereHas('roles', function($q) {
            $q->where('name', 'gerente');
        })->orderBy('name')->get();

        $statusOptions = [
            'em_planejamento' => 'Em Planejamento',
            'producao' => 'Produção',
            'montagem' => 'Montagem',
            'vistoria' => 'Vistoria',
            'concluido' => 'Concluído',
            'cancelado' => 'Cancelado',
        ];

        return view('projetos.index', compact('projetos', 'clientes', 'gerentes', 'statusOptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $clientes = Cliente::orderBy('nome')->get();
        $gerentes = User::whereHas('roles', function($q) {
            $q->where('name', 'gerente');
        })->orderBy('name')->get();
        $equipes = Equipe::withCount('membros')->orderBy('nome')->get();
        $orcamentos = Orcamento::with('cliente')
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->get();

        $statusOptions = [
            'em_planejamento' => 'Em Planejamento',
            'producao' => 'Produção',
            'montagem' => 'Montagem',
            'vistoria' => 'Vistoria',
            'concluido' => 'Concluído',
            'cancelado' => 'Cancelado',
        ];

        // Se veio de um orçamento aprovado
        $orcamentoSelecionado = null;
        $itensPrevia = collect();
        if ($request->filled('orcamento_id')) {
            $orcamentoSelecionado = Orcamento::with(['itens.unidade', 'cliente'])
                ->find($request->orcamento_id);
            
            // Criar prévia dos itens que serão criados no projeto
            if ($orcamentoSelecionado) {
                $itensPrevia = $orcamentoSelecionado->itens->map(function ($item) {
                    return (object) [
                        'descricao' => $item->descricao,
                        'observacao' => $item->observacao,
                        'quantidade' => $item->quantidade,
                        'unidade' => $item->unidade ? $item->unidade->nome : null,
                        'preco_orcado' => $item->preco_unitario,
                        'status' => 'pendente',
                        'status_label' => 'Pendente'
                    ];
                });
            }
        }

        return view('projetos.create', compact(
            'clientes',
            'gerentes',
            'equipes',
            'orcamentos',
            'statusOptions',
            'orcamentoSelecionado',
            'itensPrevia'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'nome' => 'required|string|max:150',
            'status' => 'required|in:em_planejamento,producao,montagem,vistoria,concluido,cancelado',
            'data_inicio' => 'nullable|date',
            'data_entrega_prevista' => 'nullable|date|after_or_equal:data_inicio',
            'data_entrega_real' => 'nullable|date',
            'gerente_user_id' => 'nullable|exists:users,id',
            'equipe_id' => 'nullable|exists:equipes,id',
            'orcamento_id' => 'nullable|exists:orcamentos,id',
            'observacoes' => 'nullable|string',
        ]);

        $projeto = Projeto::create($request->all());

        // Se o projeto foi criado a partir de um orçamento, criar itens automaticamente
        if ($request->orcamento_id) {
            $projeto->criarItensDoOrcamento();
        }

        return redirect()->route('projetos.show', $projeto)
            ->with('success', 'Projeto criado com sucesso!' . 
                   ($request->orcamento_id ? ' Os itens do orçamento foram incluídos no projeto.' : ''));
    }

    /**
     * Display the specified resource.
     */
    public function show(Projeto $projeto)
    {
        $projeto->load([
            'cliente',
            'orcamento',
            'gerente',
            'enderecoInstalacao',
            'equipe',
            'materiaisProjeto.material',
            'itensProjeto.itemOrcamento',
            'itensProjeto.unidade',
            'contratos'
        ]);

        return view('projetos.show', compact('projeto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Projeto $projeto)
    {
        $clientes = Cliente::orderBy('nome')->get();
        $gerentes = User::whereHas('roles', function($q) {
            $q->where('name', 'gerente');
        })->orderBy('name')->get();
        $equipes = Equipe::withCount('membros')->orderBy('nome')->get();
        $orcamentos = Orcamento::with('cliente')
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->get();

        $statusOptions = [
            'em_planejamento' => 'Em Planejamento',
            'producao' => 'Produção',
            'montagem' => 'Montagem',
            'vistoria' => 'Vistoria',
            'concluido' => 'Concluído',
            'cancelado' => 'Cancelado',
        ];

        return view('projetos.edit', compact(
            'projeto',
            'clientes',
            'gerentes',
            'equipes',
            'orcamentos',
            'statusOptions'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Projeto $projeto)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'nome' => 'required|string|max:150',
            'status' => 'required|in:em_planejamento,producao,montagem,vistoria,concluido,cancelado',
            'data_inicio' => 'nullable|date',
            'data_entrega_prevista' => 'nullable|date|after_or_equal:data_inicio',
            'data_entrega_real' => 'nullable|date',
            'gerente_user_id' => 'nullable|exists:users,id',
            'equipe_id' => 'nullable|exists:equipes,id',
            'orcamento_id' => 'nullable|exists:orcamentos,id',
            'observacoes' => 'nullable|string',
        ]);

        $projeto->update($request->all());

        return redirect()->route('projetos.show', $projeto)
            ->with('success', 'Projeto atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Projeto $projeto)
    {
        $projeto->delete();

        return redirect()->route('projetos.index')
            ->with('success', 'Projeto excluído com sucesso!');
    }

    /**
     * Exibe o formulário para importação de XML do Promob
     */
    public function mostrarImportacaoXml(Projeto $projeto)
    {
        // Verificar se usuário tem permissão
        // $this->authorize('update', $projeto);

        return view('projetos.importar-xml', compact('projeto'));
    }

    /**
     * Processa a importação de XML do Promob
     */
    public function importarXmlPromob(Request $request, Projeto $projeto, PromobXmlImportService $importService)
    {
        try {
            // Validar requisição
            $request->validate([
                'arquivos_xml' => 'required|array|min:1',
                'arquivos_xml.*' => 'required|file|mimes:xml|max:10240', // Max 10MB per file
            ], [
                'arquivos_xml.required' => 'Selecione pelo menos um arquivo XML.',
                'arquivos_xml.*.mimes' => 'Todos os arquivos devem ter extensão .xml',
                'arquivos_xml.*.max' => 'Cada arquivo deve ter no máximo 10MB.',
            ]);

            $resultadosGerais = [
                'total_arquivos' => 0,
                'arquivos_processados' => 0,
                'total_itens_importados' => 0,
                'total_erros' => 0,
                'detalhes_por_arquivo' => [],
                'erros_gerais' => []
            ];

            // Processar cada arquivo
            foreach ($request->file('arquivos_xml') as $arquivo) {
                $resultadosGerais['total_arquivos']++;
                
                try {
                    Log::info('Iniciando importação de arquivo XML', [
                        'projeto_id' => $projeto->id,
                        'arquivo' => $arquivo->getClientOriginalName()
                    ]);

                    $resultado = $importService->importarArquivo($projeto, $arquivo);
                    
                    $resultadosGerais['arquivos_processados']++;
                    $resultadosGerais['total_itens_importados'] += $resultado['sucesso'];
                    $resultadosGerais['total_erros'] += $resultado['erros'];
                    
                    $resultadosGerais['detalhes_por_arquivo'][] = [
                        'arquivo' => $arquivo->getClientOriginalName(),
                        'sucesso' => true,
                        'itens_importados' => $resultado['sucesso'],
                        'erros' => $resultado['erros'],
                        'detalhes' => $resultado['detalhes']
                    ];

                } catch (\Exception $e) {
                    $resultadosGerais['total_erros']++;
                    $resultadosGerais['erros_gerais'][] = "Erro no arquivo '{$arquivo->getClientOriginalName()}': " . $e->getMessage();
                    
                    $resultadosGerais['detalhes_por_arquivo'][] = [
                        'arquivo' => $arquivo->getClientOriginalName(),
                        'sucesso' => false,
                        'erro' => $e->getMessage()
                    ];

                    Log::error('Erro na importação de arquivo XML', [
                        'projeto_id' => $projeto->id,
                        'arquivo' => $arquivo->getClientOriginalName(),
                        'erro' => $e->getMessage()
                    ]);
                }
            }

            // Preparar mensagem de retorno
            $mensagem = "Importação concluída: {$resultadosGerais['total_itens_importados']} itens importados";
            if ($resultadosGerais['total_erros'] > 0) {
                $mensagem .= " com {$resultadosGerais['total_erros']} erros";
            }

            return redirect()->route('projetos.show', $projeto)
                ->with('success', $mensagem)
                ->with('import_details', $resultadosGerais);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (\Exception $e) {
            Log::error('Erro geral na importação XML', [
                'projeto_id' => $projeto->id,
                'erro' => $e->getMessage()
            ]);

            return redirect()->back()
                ->with('error', 'Erro na importação: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Exibe o formulário para importação de XML do Promob para um item específico
     */
    public function mostrarImportacaoXmlItem(Projeto $projeto, ItemProjeto $item)
    {
        // Verificar se o item pertence ao projeto
        if ($item->projeto_id !== $projeto->id) {
            return redirect()->route('projetos.show', $projeto)
                ->with('error', 'Item não encontrado neste projeto.');
        }

        return view('projetos.importar-xml-item', compact('projeto', 'item'));
    }

    /**
     * Processa a importação de XML do Promob para um item específico
     */
    public function importarXmlPromobItem(Request $request, Projeto $projeto, ItemProjeto $item, PromobItemMaterialImportService $importService)
    {
        try {
            // Verificar se o item pertence ao projeto
            if ($item->projeto_id !== $projeto->id) {
                return redirect()->route('projetos.show', $projeto)
                    ->with('error', 'Item não encontrado neste projeto.');
            }

            // Validar requisição
            $request->validate([
                'arquivo_xml' => 'required|file|mimes:xml|max:10240', // Max 10MB
                'substituir_existentes' => 'boolean',
            ], [
                'arquivo_xml.required' => 'Selecione um arquivo XML.',
                'arquivo_xml.mimes' => 'O arquivo deve ter extensão .xml',
                'arquivo_xml.max' => 'O arquivo deve ter no máximo 10MB.',
            ]);

            // Se solicitado, limpar materiais existentes
            if ($request->boolean('substituir_existentes')) {
                $removidos = $importService->limparMateriaisDoItem($item);
                Log::info('Materiais existentes removidos antes da importação', [
                    'item_projeto_id' => $item->id,
                    'quantidade_removida' => $removidos
                ]);
            }

            Log::info('Iniciando importação de materiais para item', [
                'projeto_id' => $projeto->id,
                'item_projeto_id' => $item->id,
                'arquivo' => $request->file('arquivo_xml')->getClientOriginalName()
            ]);

            $resultado = $importService->importarMateriaisParaItem($item, $request->file('arquivo_xml'));
            
            // Preparar mensagem de retorno
            $mensagem = "Importação concluída: {$resultado['sucesso']} materiais importados para o item '{$item->descricao}'";
            if ($resultado['erros'] > 0) {
                $mensagem .= " com {$resultado['erros']} erros";
            }

            return redirect()->route('projetos.show', $projeto)
                ->with('success', $mensagem)
                ->with('import_item_details', $resultado);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (\Exception $e) {
            Log::error('Erro na importação de materiais para item', [
                'projeto_id' => $projeto->id,
                'item_projeto_id' => $item->id,
                'erro' => $e->getMessage()
            ]);

            return redirect()->back()
                ->with('error', 'Erro na importação: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Lista os materiais importados para um item específico (API)
     */
    public function listarMateriaisItem(Projeto $projeto, ItemProjeto $item)
    {
        // Verificar se o item pertence ao projeto
        if ($item->projeto_id !== $projeto->id) {
            return response()->json(['error' => 'Item não encontrado neste projeto'], 404);
        }

        $materiais = $item->materiaisPromob()
            ->orderBy('categoria')
            ->orderBy('descricao')
            ->get();

        return response()->json([
            'success' => true,
            'item' => [
                'id' => $item->id,
                'descricao' => $item->descricao,
            ],
            'materiais' => $materiais,
            'total_materiais' => $materiais->count(),
            'categorias' => $materiais->pluck('categoria')->unique()->values()
        ]);
    }

    /**
     * Remove todos os materiais de um item específico
     */
    public function limparMateriaisItem(Projeto $projeto, ItemProjeto $item, PromobItemMaterialImportService $importService)
    {
        try {
            // Verificar se o item pertence ao projeto
            if ($item->projeto_id !== $projeto->id) {
                return response()->json(['error' => 'Item não encontrado neste projeto'], 404);
            }

            $removidos = $importService->limparMateriaisDoItem($item);

            return response()->json([
                'success' => true,
                'message' => "Foram removidos {$removidos} materiais do item '{$item->descricao}'",
                'materiais_removidos' => $removidos
            ]);

        } catch (\Exception $e) {
            Log::error('Erro ao limpar materiais do item', [
                'projeto_id' => $projeto->id,
                'item_projeto_id' => $item->id,
                'erro' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro ao remover materiais: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Atualiza o progresso de um item do projeto
     */
    public function atualizarProgressoItem(Request $request, Projeto $projeto, $itemId)
    {
        $request->validate([
            'percentual_concluido' => 'required|numeric|min:0|max:100',
        ]);

        $item = $projeto->itensProjeto()->findOrFail($itemId);
        $item->atualizarProgresso($request->percentual_concluido);

        return response()->json([
            'success' => true,
            'item' => [
                'id' => $item->id,
                'percentual_concluido' => $item->percentual_concluido,
                'status' => $item->status,
                'status_label' => $item->status_label,
                'status_badge_class' => $item->status_badge_class,
            ]
        ]);
    }

    /**
     * API para criar itens do orçamento automaticamente
     */
    public function criarItensOrcamento(Projeto $projeto)
    {
        try {
            if (!$projeto->orcamento) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este projeto não está vinculado a um orçamento.'
                ], 400);
            }

            if ($projeto->itensProjeto()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este projeto já possui itens. Exclua os itens existentes antes de criar novos.'
                ], 400);
            }

            $itensCreated = $projeto->criarItensDoOrcamento();

            if ($itensCreated > 0) {
                return response()->json([
                    'success' => true,
                    'message' => "{$itensCreated} itens criados com sucesso!",
                    'itens_criados' => $itensCreated
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Nenhum item foi criado. Verifique se o orçamento possui itens.'
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Erro ao criar itens do orçamento', [
                'projeto_id' => $projeto->id,
                'erro' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro interno: ' . $e->getMessage()
            ], 500);
        }
    }
}
