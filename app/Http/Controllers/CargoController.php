<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCargoRequest;
use App\Http\Requests\UpdateCargoRequest;

class CargoController extends Controller
{
    public function index(Request $request)
    {
        $query = Cargo::query();
        if ($request->filled('search_nome')) {
            $query->where('nome', 'like', '%' . $request->search_nome . '%');
        }
        $cargos = $query->paginate(10)->appends($request->query());
        return view('cargos.index', compact('cargos'));
    }

    public function create()
    {
        return view('cargos.create');
    }

    public function store(StoreCargoRequest $request)
    {
        $cargo = Cargo::create($request->validated());
        return redirect()->route('cargos.index')->with('success', 'Cargo criado com sucesso!');
    }

    public function show(Cargo $cargo)
    {
        return view('cargos.show', compact('cargo'));
    }

    public function edit(Cargo $cargo)
    {
        return view('cargos.edit', compact('cargo'));
    }

    public function update(UpdateCargoRequest $request, Cargo $cargo)
    {
        $cargo->update($request->validated());
        return redirect()->route('cargos.index')->with('success', 'Cargo atualizado com sucesso!');
    }

    public function destroy(Cargo $cargo)
    {
        $cargo->delete();
        return redirect()->route('cargos.index')->with('success', 'Cargo excluído com sucesso!');
    }
}
