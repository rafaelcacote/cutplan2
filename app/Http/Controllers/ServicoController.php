<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use App\Http\Requests\StoreServicoRequest;
use App\Http\Requests\UpdateServicoRequest;
use Illuminate\Http\Request;

class ServicoController extends Controller
{
    public function index(Request $request)
    {
        $query = Servico::query();
        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%'.$request->nome.'%');
        }
        if ($request->filled('ativo')) {
            $query->where('ativo', $request->ativo);
        }
        $servicos = $query->paginate(10)->appends($request->query());
        return view('servicos.index', compact('servicos'));
    }

    public function create()
    {
        return view('servicos.create');
    }

    public function store(StoreServicoRequest $request)
    {
        Servico::create($request->validated());
        return redirect()->route('servicos.index')->with('success', 'Serviço criado com sucesso!');
    }

    public function show(Servico $servico)
    {
        return view('servicos.show', compact('servico'));
    }

    public function edit(Servico $servico)
    {
        return view('servicos.edit', compact('servico'));
    }

    public function update(UpdateServicoRequest $request, Servico $servico)
    {
        $servico->update($request->validated());
        return redirect()->route('servicos.index')->with('success', 'Serviço atualizado com sucesso!');
    }

    public function destroy(Servico $servico)
    {
        $servico->delete();
        return redirect()->route('servicos.index')->with('success', 'Serviço excluído com sucesso!');
    }
}
