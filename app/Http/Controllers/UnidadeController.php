<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use Illuminate\Http\Request;

class UnidadeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $perPage = 10;
        $query = Unidade::query();
        if ($request->filled('search_nome')) {
            $query->where('nome', 'like', '%' . $request->search_nome . '%');
        }
        if ($request->filled('search_codigo')) {
            $query->where('codigo', 'like', '%' . $request->search_codigo . '%');
        }
        $unidades = $query->paginate($perPage);
        $unidades->appends($request->query());
        return view('unidades.index', compact('unidades'));
    }

    public function create()
    {
        return view('unidades.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:16|unique:unidades,codigo',
            'nome' => 'required|string|max:64',
            'precisao' => 'required|integer|min:0|max:10',
        ]);
        Unidade::create($validated);
        return redirect()->route('unidades.index')->with('success', 'Unidade criada com sucesso!');
    }

    public function show(Unidade $unidade)
    {
        return view('unidades.show', compact('unidade'));
    }

    public function edit(Unidade $unidade)
    {
        return view('unidades.edit', compact('unidade'));
    }

    public function update(Request $request, Unidade $unidade)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:16|unique:unidades,codigo,' . $unidade->id,
            'nome' => 'required|string|max:64',
            'precisao' => 'required|integer|min:0|max:10',
        ]);
        $unidade->update($validated);
        return redirect()->route('unidades.index')->with('success', 'Unidade atualizada com sucesso!');
    }

    public function destroy(Unidade $unidade)
    {
        $unidade->delete();
        return redirect()->route('unidades.index')->with('success', 'Unidade excluída com sucesso!');
    }
}
