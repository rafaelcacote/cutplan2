<?php

namespace App\Http\Controllers;

use App\Models\Projeto;
use App\Models\Cliente;
use App\Models\User;
use App\Models\Endereco;
use App\Models\Equipe;
use App\Models\Orcamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if ($request->filled('orcamento_id')) {
            $orcamentoSelecionado = Orcamento::find($request->orcamento_id);
        }

        return view('projetos.create', compact(
            'clientes',
            'gerentes',
            'equipes',
            'orcamentos',
            'statusOptions',
            'orcamentoSelecionado'
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

        return redirect()->route('projetos.show', $projeto)
            ->with('success', 'Projeto criado com sucesso!');
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
}
