<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\Role;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:usuarios.listar')->only('index');
        $this->middleware('can:usuarios.criar')->only(['create', 'store']);
        $this->middleware('can:usuarios.editar')->only(['edit', 'update']);
        $this->middleware('can:usuarios.excluir')->only('destroy');
    }

    public function index(Request $request)
    {
        $perPage = 10; // Defina aqui a quantidade de usuários por página

        $query = User::with(['tenant', 'roles']);

        // Filtro por nome
        if ($request->filled('search_name')) {
            $query->where('name', 'like', '%' . $request->search_name . '%');
        }

        // Filtro por CPF
        if ($request->filled('search_cpf')) {
            $cpf = preg_replace('/[^0-9]/', '', $request->search_cpf);
            $query->where('cpf', 'like', '%' . $cpf . '%');
        }

        $users = $query->paginate($perPage);

        // Manter os parâmetros de busca na paginação
        $users->appends($request->query());

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        $tenants = Tenant::orderBy('nome')->get();
        return view('users.create', compact('roles', 'tenants'));
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        // Remove caracteres não numéricos do CPF
        if (!empty($validated['cpf'])) {
            $validated['cpf'] = preg_replace('/[^0-9]/', '', $validated['cpf']);
        }
        $validated['password'] = Hash::make($validated['password']);
        // Salva o id do usuário autenticado
        $validated['user_id'] = auth()->id();

        $user = User::create($validated);

        // Atribuir perfil ao usuário
        if ($request->has('role') && !empty($request->role)) {
            $user->assignRole($request->role);
        }

        return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso!');
    }

    public function show(User $user)
    {
        $user->load(['tenant', 'roles', 'creator']);
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $tenants = Tenant::orderBy('nome')->get();
        return view('users.edit', compact('user', 'roles', 'tenants'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        // Remove caracteres não numéricos do CPF
        if (!empty($validated['cpf'])) {
            $validated['cpf'] = preg_replace('/[^0-9]/', '', $validated['cpf']);
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        // Atualizar perfil do usuário
        if ($request->has('role') && !empty($request->role)) {
            $user->syncRoles([$request->role]);
        } else {
            $user->syncRoles([]);
        }

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso!');
    }
}
