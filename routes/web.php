<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rotas de CRUD de usuários
    Route::resource('users', UserController::class);

    // Rotas de CRUD de clientes
    Route::resource('clientes', App\Http\Controllers\ClienteController::class);

    // Rotas de CRUD de fornecedores (com parâmetro customizado)
    Route::resource('fornecedores', App\Http\Controllers\FornecedorController::class)->parameters([
        'fornecedores' => 'fornecedor'
    ]);
    
    // Rotas de CRUD de perfis (roles)
    Route::resource('roles', App\Http\Controllers\RoleController::class);

    // Rotas de CRUD de permissões
    Route::resource('permissions', App\Http\Controllers\PermissionController::class);

    // Rotas para atribuir perfis ao usuário
    Route::get('users/{user}/permissions', [App\Http\Controllers\UserPermissionController::class, 'edit'])->name('users.permissions.edit');
    Route::put('users/{user}/permissions', [App\Http\Controllers\UserPermissionController::class, 'update'])->name('users.permissions.update');
});

require __DIR__.'/auth.php';
