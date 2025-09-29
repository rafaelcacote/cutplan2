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
        $validated['tenant_id'] = auth()->user()->tenant_id;
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
        // Exclui todos os membros vinculados a esta equipe
        foreach ($equipe->membros as $membro) {
            $membro->delete();
        }
        // Remove os vínculos da tabela pivô (opcional, pois o delete acima já faz isso se for cascade)
        $equipe->membros()->detach();
        $equipe->delete();
        return redirect()->route('equipes.index')->with('success', 'Equipe excluída com sucesso!');
    }

    // Botão para gerenciar membros da equipe
    public function membros(Equipe $equipe)
    {
    $equipe->load('membros');
    // Só mostra membros que ainda não estão na equipe
    $membros = Membro::whereNotIn('id', $equipe->membros->pluck('id'))->get();
    return view('equipes.membros', compact('equipe', 'membros'));
    }

    // Adiciona um membro à equipe
    public function adicionarMembro(Request $request, Equipe $equipe)
    {
        $request->validate([
            'membro_id' => 'required|exists:membros,id',
        ]);
        // Verifica se o membro já está na equipe
        if ($equipe->membros()->where('membro_id', $request->membro_id)->exists()) {
            if ($request->wantsJson() || $request->isJson() || $request->ajax()) {
                return response()->json(['error' => 'Este membro já faz parte da equipe!'], 422);
            }
            return redirect()->route('equipes.membros', $equipe->id)
                ->with('error', 'Este membro já faz parte da equipe!');
        }
        // Supondo relação muitos-para-muitos: equipe_membro
        $equipe->membros()->attach($request->membro_id, [
            'funcao' => $request->input('funcao')
        ]);
        if ($request->wantsJson() || $request->isJson() || $request->ajax()) {
            return response()->json(['success' => 'Membro adicionado com sucesso!']);
        }
        return redirect()->route('equipes.membros', $equipe->id)
            ->with('success', 'Membro adicionado com sucesso!');
    }

    // Remove um membro da equipe
    public function removerMembro(Request $request, Equipe $equipe, Membro $membro)
    {
        // Verifica se o membro está realmente na equipe
        if (!$equipe->membros()->where('membro_id', $membro->id)->exists()) {
            if ($request->wantsJson() || $request->isJson() || $request->ajax()) {
                return response()->json(['error' => 'Este membro não faz parte desta equipe!'], 422);
            }
            return redirect()->route('equipes.membros', $equipe->id)
                ->with('error', 'Este membro não faz parte desta equipe!');
        }
        
        $equipe->membros()->detach($membro->id);
        
        if ($request->wantsJson() || $request->isJson() || $request->ajax()) {
            return response()->json(['success' => 'Membro removido com sucesso!']);
        }
        return redirect()->route('equipes.membros', $equipe->id)
            ->with('success', 'Membro removido com sucesso!');
    }
}
