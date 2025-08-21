<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserPermissionController extends Controller
{
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.permissions', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ]);
        $user->syncRoles($request->roles ?? []);
        return redirect()->route('users.index')->with('success', 'Permissões atualizadas com sucesso!');
    }
}
