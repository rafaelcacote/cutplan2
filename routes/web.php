<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('auth.login');
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

        // Rotas de CRUD de cargos
        Route::resource('cargos', \App\Http\Controllers\CargoController::class);


    // Rotas de CRUD de membros
    Route::resource('membros', App\Http\Controllers\MembroController::class);

    // Rotas de CRUD de equipes
    Route::resource('equipes', App\Http\Controllers\EquipeController::class);
    // Rota para gerenciar membros da equipe
    Route::get('equipes/{equipe}/membros', [App\Http\Controllers\EquipeController::class, 'membros'])->name('equipes.membros');
    // Rota para adicionar membro à equipe (POST)
    Route::post('equipes/{equipe}/membros', [App\Http\Controllers\EquipeController::class, 'adicionarMembro'])->name('equipes.membros.adicionar');
    // Rota para remover membro da equipe (DELETE)
    Route::delete('equipes/{equipe}/membros/{membro}', [App\Http\Controllers\EquipeController::class, 'removerMembro'])->name('equipes.membros.remover');

    // Rotas de CRUD de materiais
    Route::resource('materiais', App\Http\Controllers\MaterialController::class)
        ->parameters(['materiais' => 'material']);

        // Rota para cadastro rápido de tipo de material via AJAX
        Route::post('tipos-materiais', [App\Http\Controllers\TipoMaterialController::class, 'store'])->name('tipos-materiais.store');

    // Rotas de CRUD de serviços
    Route::resource('servicos', App\Http\Controllers\ServicoController::class);

    // Rotas de CRUD de itens de serviço
    Route::resource('itens-servico', App\Http\Controllers\ItemServicoController::class);

    // Rotas de CRUD de tipos de materiais
    Route::resource('tipos-materiais', App\Http\Controllers\TipoMaterialController::class)->parameters(['tipos-materiais' => 'tipoMaterial']);

    // Rotas de CRUD de unidades
    Route::resource('unidades', App\Http\Controllers\UnidadeController::class);

    // Rotas de CRUD de orçamentos
    Route::resource('orcamentos', App\Http\Controllers\OrcamentoController::class);
    
    // Rotas API para orçamentos
    Route::get('orcamentos/api/servicos', [App\Http\Controllers\OrcamentoController::class, 'getServicos'])->name('orcamentos.get-servicos');
    Route::get('orcamentos/servicos/{servico}/itens', [App\Http\Controllers\OrcamentoController::class, 'getItensServico'])->name('orcamentos.get-itens-servico');
    Route::get('orcamentos/api/unidades', [App\Http\Controllers\OrcamentoController::class, 'getUnidades'])->name('orcamentos.get-unidades');
    Route::post('orcamentos/{orcamento}/status', [App\Http\Controllers\OrcamentoController::class, 'updateStatus'])->name('orcamentos.update-status');
});

require __DIR__.'/auth.php';
