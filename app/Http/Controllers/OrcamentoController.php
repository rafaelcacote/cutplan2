<?php

namespace App\Http\Controllers;

use App\Models\Orcamento;
use App\Models\ItemOrcamento;
use App\Models\Cliente;
use App\Models\Servico;
use App\Models\ItemServico;
use App\Models\Unidade;
use App\Http\Requests\StoreOrcamentoRequest;
use App\Http\Requests\UpdateOrcamentoRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OrcamentoController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 10;
        $query = Orcamento::with(['cliente', 'user']);

        // Filtros
        if ($request->filled('search_cliente')) {
            $query->whereHas('cliente', function($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->search_cliente . '%');
            });
        }

        if ($request->filled('search_status')) {
            $query->where('status', $request->search_status);
        }

        if ($request->filled('search_data_inicio')) {
            $query->whereDate('created_at', '>=', $request->search_data_inicio);
        }

        if ($request->filled('search_data_fim')) {
            $query->whereDate('created_at', '<=', $request->search_data_fim);
        }

        $orcamentos = $query->orderBy('created_at', 'desc')->paginate($perPage);
        $orcamentos->appends($request->query());

        return view('orcamentos.index', compact('orcamentos'));
    }

    public function create()
    {
        $clientes = Cliente::orderBy('nome')->get();
        return view('orcamentos.create', compact('clientes'));
    }

    public function store(StoreOrcamentoRequest $request)
    {
        $validated = $request->validated();

        // Criar orçamento
        $orcamento = Orcamento::create([
            'cliente_id' => $validated['cliente_id'],
            'status' => 'draft',
            'validade' => $validated['validade'] ?? null,
            'desconto' => $validated['desconto'] ?? 0,
            'user_id' => auth()->id(),
            'observacoes' => $validated['observacoes'] ?? null,
        ]);

        // Criar itens
        foreach ($validated['itens'] as $itemData) {
            ItemOrcamento::create([
                'orcamento_id' => $orcamento->id,
                'descricao' => $itemData['descricao'],
                'quantidade' => $itemData['quantidade'],
                'unidade_id' => $itemData['unidade_id'] ?? null,
                'preco_unitario' => $itemData['preco_unitario'],
                'item_servico_id' => $itemData['item_servico_id'] ?? null,
            ]);
        }

        return redirect()->route('orcamentos.index')->with('success', 'Orçamento criado com sucesso!');
    }

    public function show(Orcamento $orcamento)
    {
        $orcamento->load(['cliente.endereco', 'itens.unidade', 'itens.itemServico', 'user']);
        return view('orcamentos.show', compact('orcamento'));
    }

    public function edit(Orcamento $orcamento)
    {
        $orcamento->load(['itens.unidade', 'itens.itemServico']);
        $clientes = Cliente::orderBy('nome')->get();
        $servicos = Servico::where('ativo', true)->orderBy('nome')->get();
        $unidades = Unidade::orderBy('nome')->get();
        
        return view('orcamentos.edit', compact('orcamento', 'clientes', 'servicos', 'unidades'));
    }

    public function update(UpdateOrcamentoRequest $request, Orcamento $orcamento)
    {
        $validated = $request->validated();

        // Atualizar orçamento
        $orcamento->update([
            'cliente_id' => $validated['cliente_id'],
            'status' => $validated['status'],
            'validade' => $validated['validade'] ?? null,
            'desconto' => $validated['desconto'] ?? 0,
            'observacoes' => $validated['observacoes'] ?? null,
        ]);

        // Remover itens existentes
        $orcamento->itens()->delete();

        // Criar novos itens
        foreach ($validated['itens'] as $itemData) {
            ItemOrcamento::create([
                'orcamento_id' => $orcamento->id,
                'descricao' => $itemData['descricao'],
                'quantidade' => $itemData['quantidade'],
                'unidade_id' => $itemData['unidade_id'] ?? null,
                'preco_unitario' => $itemData['preco_unitario'],
                'item_servico_id' => $itemData['item_servico_id'] ?? null,
            ]);
        }

        return redirect()->route('orcamentos.index')->with('success', 'Orçamento atualizado com sucesso!');
    }

    public function destroy(Orcamento $orcamento)
    {
        $orcamento->delete();
        return redirect()->route('orcamentos.index')->with('success', 'Orçamento excluído com sucesso!');
    }

    // API Methods para AJAX
    public function getServicos(): JsonResponse
    {
        $servicos = Servico::where('ativo', true)
            ->orderBy('nome')
            ->get(['id', 'nome']);
        
        return response()->json($servicos);
    }

    public function getItensServico(Servico $servico): JsonResponse
    {
        $itens = ItemServico::where('servico_id', $servico->id)
            ->get(['id', 'descricao_item', 'servico_id']);
        return response()->json($itens);
    }

    public function getUnidades(): JsonResponse
    {
        $unidades = Unidade::orderBy('nome')->get(['id', 'nome', 'simbolo']);
        return response()->json($unidades);
    }

    public function updateStatus(Request $request, Orcamento $orcamento): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:draft,sent,approved,rejected,expired'
        ]);

        $orcamento->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status atualizado com sucesso!',
            'status' => $orcamento->status,
            'status_label' => $orcamento->status_label,
            'status_badge' => $orcamento->status_badge
        ]);
    }
}
