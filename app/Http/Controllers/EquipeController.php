<?php
namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Models\Membro;
use App\Http\Requests\StoreEquipeRequest;
use App\Http\Requests\UpdateEquipeRequest;
use Illuminate\Http\Request;

class EquipeController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 10;
        $query = Equipe::with(['lider']);
        if ($request->filled('search_nome')) {
            $query->where('nome', 'like', '%' . $request->search_nome . '%');
        }
        if ($request->filled('search_ativo')) {
            $query->where('ativo', $request->search_ativo);
        }
        $equipes = $query->paginate($perPage);
        $equipes->appends($request->query());
        return view('equipes.index', compact('equipes'));
    }

    public function create()
    {
        $membros = Membro::all();
        return view('equipes.create', compact('membros'));
    }

    public function store(StoreEquipeRequest $request)
    {
        $validated = $request->validated();
        Equipe::create($validated);
        return redirect()->route('equipes.index')->with('success', 'Equipe criada com sucesso!');
    }

    public function show(Equipe $equipe)
    {
        $equipe->load(['lider', 'membros']);
        return view('equipes.show', compact('equipe'));
    }

    public function edit(Equipe $equipe)
    {
        $membros = Membro::all();
        return view('equipes.edit', compact('equipe', 'membros'));
    }

    public function update(UpdateEquipeRequest $request, Equipe $equipe)
    {
        $validated = $request->validated();
        $equipe->update($validated);
        return redirect()->route('equipes.index')->with('success', 'Equipe atualizada com sucesso!');
    }

    public function destroy(Equipe $equipe)
    {
        $equipe->delete();
        return redirect()->route('equipes.index')->with('success', 'Equipe excluída com sucesso!');
    }

    // Botão para gerenciar membros da equipe
    public function membros(Equipe $equipe)
    {
        $equipe->load('membros');
        $membros = Membro::all();
        return view('equipes.membros', compact('equipe', 'membros'));
    }
}
