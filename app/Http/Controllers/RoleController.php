<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
        public function __construct()
    {
        $this->middleware('can:perfis.listar')->only('index');
        $this->middleware('can:perfis.criar')->only(['create', 'store']);
        $this->middleware('can:perfis.editar')->only(['edit', 'update']);
        $this->middleware('can:perfis.excluir')->only('destroy');
        $this->middleware('can:perfis.visualizar')->only('show');
    }

    public function index()
    {
        $roles = Role::paginate(15);
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $validated = $request->validated();
        $validated['guard_name'] = $validated['guard_name'] ?? 'web';

        $role = Role::create($validated);
        $role->syncPermissions($request->permissions ?? []);
        return redirect()->route('roles.index')->with('success', 'Perfil criado com sucesso!');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $validated = $request->validated();
        $validated['guard_name'] = $validated['guard_name'] ?? 'web';

        $role->update($validated);
        $role->syncPermissions($request->permissions ?? []);
        return redirect()->route('roles.index')->with('success', 'Perfil atualizado com sucesso!');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Perfil removido com sucesso!');
    }
}
