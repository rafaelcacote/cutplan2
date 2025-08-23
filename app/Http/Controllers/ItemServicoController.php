<?php

namespace App\Http\Controllers;

use App\Models\ItemServico;
use App\Models\Servico;
use App\Http\Requests\StoreItemServicoRequest;
use App\Http\Requests\UpdateItemServicoRequest;
use Illuminate\Http\Request;

class ItemServicoController extends Controller
{
    public function index(Request $request)
    {
        $query = ItemServico::with('servico');
        if ($request->filled('descricao_item')) {
            $query->where('descricao_item', 'like', '%'.$request->descricao_item.'%');
        }
        if ($request->filled('servico_id')) {
            $query->where('servico_id', $request->servico_id);
        }
        $itens = $query->paginate(10)->appends($request->query());
        $servicos = Servico::orderBy('nome')->get();
        return view('itens_servico.index', compact('itens', 'servicos'));
    }

    public function create()
    {
        $servicos = Servico::orderBy('nome')->get();
        return view('itens_servico.create', compact('servicos'));
    }

    public function store(StoreItemServicoRequest $request)
    {
        ItemServico::create($request->validated());
        return redirect()->route('itens-servico.index')->with('success', 'Item de serviço criado com sucesso!');
    }

    public function show(ItemServico $itens_servico)
    {
        return view('itens_servico.show', ['item' => $itens_servico]);
    }

    public function edit(ItemServico $itens_servico)
    {
        $servicos = Servico::orderBy('nome')->get();
        return view('itens_servico.edit', ['item' => $itens_servico, 'servicos' => $servicos]);
    }

    public function update(UpdateItemServicoRequest $request, ItemServico $itens_servico)
    {
        $itens_servico->update($request->validated());
        return redirect()->route('itens-servico.index')->with('success', 'Item de serviço atualizado com sucesso!');
    }

    public function destroy(ItemServico $itens_servico)
    {
        $itens_servico->delete();
        return redirect()->route('itens-servico.index')->with('success', 'Item de serviço excluído com sucesso!');
    }
}
