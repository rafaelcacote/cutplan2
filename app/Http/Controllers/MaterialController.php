<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\TipoMaterial;
use App\Models\Unidade;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $query = Material::query();
        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%'.$request->nome.'%');
        }
        if ($request->filled('ativo')) {
            $query->where('ativo', $request->ativo);
        }
        $materiais = $query->paginate(10)->appends($request->query());
        return view('materiais.index', compact('materiais'));
    }

    public function create()
    {
        $tipos = TipoMaterial::all();
        $unidades = Unidade::all();
        return view('materiais.create', compact('tipos', 'unidades'));
    }

    public function store(StoreMaterialRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['tenant_id'] = Auth::user()->tenant_id;
        Material::create($data);
        return redirect()->route('materiais.index')->with('success', 'Item criado com sucesso!');
    }

    public function show(Material $material)
    {
        return view('materiais.show', compact('material'));
    }

    public function edit(Material $material)
    {
        $tipos = TipoMaterial::all();
        $unidades = Unidade::all();
        return view('materiais.edit', compact('material', 'tipos', 'unidades'));
    }

    public function update(UpdateMaterialRequest $request, Material $material)
    {
        $data = $request->validated();
        $material->update($data);
        return redirect()->route('materiais.index')->with('success', 'Item atualizado com sucesso!');
    }

    public function destroy(Material $material)
    {
        $material->delete();
        return redirect()->route('materiais.index')->with('success', 'Item excluído com sucesso!');
    }
}
