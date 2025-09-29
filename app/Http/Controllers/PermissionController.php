<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;

class PermissionController extends Controller
{
            public function __construct()
    {
        $this->middleware('can:permissoes.listar')->only('index');
        $this->middleware('can:permissoes.criar')->only(['create', 'store']);
        $this->middleware('can:permissoes.editar')->only(['edit', 'update']);
        $this->middleware('can:permissoes.excluir')->only('destroy');
    }
    public function index(Request $request)
    {
        $perPage = 10;

        $query = Permission::query();

        // Filtro por nome da permissão
        if ($request->filled('search_name')) {
            $query->where('name', 'like', '%' . $request->search_name . '%');
        }

        // Filtro por módulo (primeira parte do nome)
        if ($request->filled('search_module')) {
            $query->where('name', 'like', $request->search_module . '.%');
        }

        $permissions = $query->paginate($perPage);

        // Manter os parâmetros de busca na paginação
        $permissions->appends($request->query());

        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(StorePermissionRequest $request)
    {
        $validated = $request->validated();
        $validated['guard_name'] = $validated['guard_name'] ?? 'web';

        Permission::create($validated);
        return redirect()->route('permissions.index')->with('success', 'Permissão criada com sucesso!');
    }

    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $validated = $request->validated();
        $validated['guard_name'] = $validated['guard_name'] ?? 'web';

        $permission->update($validated);
        return redirect()->route('permissions.index')->with('success', 'Permissão atualizada com sucesso!');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permissão removida com sucesso!');
    }
}
