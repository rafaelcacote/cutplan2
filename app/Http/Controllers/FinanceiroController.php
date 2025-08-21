<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinanceiroController extends Controller
{
    public function __construct()
    {
        // Protege cada ação com a permissão correta
        $this->middleware('can:financeiro.listar')->only('index');
        $this->middleware('can:financeiro.criar')->only(['create', 'store']);
        $this->middleware('can:financeiro.editar')->only(['edit', 'update']);
        $this->middleware('can:financeiro.excluir')->only('destroy');
    }

    public function index()
    {
        // Listar lançamentos financeiros
        return view('financeiro.index');
    }

    public function create()
    {
        // Formulário de novo lançamento
        return view('financeiro.create');
    }

    public function store(Request $request)
    {
        // Salvar novo lançamento
    }

    public function edit($id)
    {
        // Editar lançamento
    }

    public function update(Request $request, $id)
    {
        // Atualizar lançamento
    }

    public function destroy($id)
    {
        // Excluir lançamento
    }
}
