<?php
namespace App\Http\Controllers;

use App\Models\Membro;
use App\Http\Requests\StoreMembroRequest;
use App\Http\Requests\UpdateMembroRequest;
use Illuminate\Http\Request;

class MembroController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 10;
        $query = Membro::query();
        if ($request->filled('search_nome')) {
            $query->where('nome', 'like', '%' . $request->search_nome . '%');
        }
        if ($request->filled('search_email')) {
            $query->where('email', 'like', '%' . $request->search_email . '%');
        }
        $membros = $query->paginate($perPage);
        $membros->appends($request->query());
        return view('membros.index', compact('membros'));
    }

    public function create()
    {
        $cargos = \App\Models\Cargo::where('ativo', 1)->orderBy('nome')->get();
        return view('membros.create', compact('cargos'));
    }

    public function store(StoreMembroRequest $request)
    {
        $validated = $request->validated();
        $validated['tenant_id'] = auth()->user()->tenant_id;
        Membro::create($validated);
        return redirect()->route('membros.index')->with('success', 'Membro criado com sucesso!');
    }

    public function show(Membro $membro)
    {
        return view('membros.show', compact('membro'));
    }

    public function edit(Membro $membro)
    {
        $cargos = \App\Models\Cargo::where('ativo', 1)->orderBy('nome')->get();
        return view('membros.edit', compact('membro', 'cargos'));
    }

    public function update(UpdateMembroRequest $request, Membro $membro)
    {
        $validated = $request->validated();
        $membro->update($validated);
        return redirect()->route('membros.index')->with('success', 'Membro atualizado com sucesso!');
    }

    public function destroy(Membro $membro)
    {
        $membro->delete();
        return redirect()->route('membros.index')->with('success', 'Membro excluído com sucesso!');
    }
}
