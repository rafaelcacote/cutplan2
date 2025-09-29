<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('auth.login');
});

// Rota pública para visualização de orçamentos (sem autenticação)
Route::get('orcamentos/public/{uuid}', [App\Http\Controllers\OrcamentoController::class, 'publicView'])->name('orcamentos.public');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rotas de CRUD de empresas (tenants)
    Route::resource('tenants', App\Http\Controllers\TenantController::class);

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

    // Novas rotas para ações pós-criação do orçamento
    Route::get('orcamentos/{orcamento}/actions', [App\Http\Controllers\OrcamentoController::class, 'actions'])->name('orcamentos.actions');
    Route::get('orcamentos/{orcamento}/pdf', [App\Http\Controllers\OrcamentoController::class, 'generatePdf'])->name('orcamentos.pdf');
    Route::post('orcamentos/{orcamento}/send-email', [App\Http\Controllers\OrcamentoController::class, 'sendEmail'])->name('orcamentos.send-email');
    Route::get('orcamentos/{orcamento}/send-whatsapp', [App\Http\Controllers\OrcamentoController::class, 'sendWhatsApp'])->name('orcamentos.send-whatsapp');

    // Rotas API para orçamentos
    Route::get('orcamentos/api/servicos', [App\Http\Controllers\OrcamentoController::class, 'getServicos'])->name('orcamentos.get-servicos');
    Route::get('orcamentos/servicos/{servico}', [App\Http\Controllers\OrcamentoController::class, 'getServico'])->name('orcamentos.get-servico');
    Route::get('orcamentos/servicos/{servico}/itens', [App\Http\Controllers\OrcamentoController::class, 'getItensServico'])->name('orcamentos.get-itens-servico');
    Route::get('orcamentos/api/unidades', [App\Http\Controllers\OrcamentoController::class, 'getUnidades'])->name('orcamentos.get-unidades');
    Route::post('orcamentos/{orcamento}/status', [App\Http\Controllers\OrcamentoController::class, 'updateStatus'])->name('orcamentos.update-status');

    // Rotas de CRUD de projetos
    Route::resource('projetos', App\Http\Controllers\ProjetoController::class);
    
    // Contratos - gerar e download
    Route::post('projetos/{projeto}/contratos/gerar-cliente', [App\Http\Controllers\ContratoController::class, 'gerarContratoCliente'])->name('projetos.contratos.gerar-cliente');
    Route::get('contratos/{contrato}/download', [App\Http\Controllers\ContratoController::class, 'download'])->name('contratos.download');

    // Rotas específicas para projetos
    Route::get('projetos/{projeto}/importar-xml', [App\Http\Controllers\ProjetoController::class, 'mostrarImportacaoXml'])->name('projetos.importar-xml');
    Route::post('projetos/{projeto}/importar-xml', [App\Http\Controllers\ProjetoController::class, 'importarXmlPromob'])->name('projetos.importar-xml.processar');
    Route::post('projetos/{projeto}/criar-itens-orcamento', [App\Http\Controllers\ProjetoController::class, 'criarItensOrcamento'])->name('projetos.criar-itens-orcamento');
    Route::put('projetos/{projeto}/itens/{item}/progresso', [App\Http\Controllers\ProjetoController::class, 'atualizarProgressoItem'])->name('projetos.itens.progresso');
    
    // Rotas para importação de materiais por item
    Route::get('projetos/{projeto}/itens/{item}/importar-xml', [App\Http\Controllers\ProjetoController::class, 'mostrarImportacaoXmlItem'])->name('projetos.itens.importar-xml');
    Route::post('projetos/{projeto}/itens/{item}/importar-xml', [App\Http\Controllers\ProjetoController::class, 'importarXmlPromobItem'])->name('projetos.itens.importar-xml.processar');
    Route::get('projetos/{projeto}/itens/{item}/materiais', [App\Http\Controllers\ProjetoController::class, 'listarMateriaisItem'])->name('projetos.itens.materiais');
    Route::delete('projetos/{projeto}/itens/{item}/materiais', [App\Http\Controllers\ProjetoController::class, 'limparMateriaisItem'])->name('projetos.itens.materiais.limpar');

    // Rotas para importação de materiais do Promob
    Route::prefix('projetos/itens/{item_projeto}')->group(function () {
        Route::get('/promob/import', [App\Http\Controllers\PromobImportController::class, 'show'])->name('projetos.itens.promob.import');
        Route::post('/promob/preview', [App\Http\Controllers\PromobImportController::class, 'preview'])->name('projetos.itens.promob.preview');
        Route::post('/promob/import', [App\Http\Controllers\PromobImportController::class, 'import'])->name('projetos.itens.promob.import.execute');
        Route::get('/promob/materiais', [App\Http\Controllers\PromobImportController::class, 'materiais'])->name('projetos.itens.promob.materiais');
        Route::delete('/promob/materiais/{material}', [App\Http\Controllers\PromobImportController::class, 'removeMaterial'])->name('projetos.itens.promob.materiais.remove');
        Route::put('/promob/materiais/{material}/vincular', [App\Http\Controllers\PromobImportController::class, 'vincularMaterial'])->name('projetos.itens.promob.materiais.vincular');
        Route::delete('/promob/materiais/{material}/desvincular', [App\Http\Controllers\PromobImportController::class, 'desvincularMaterial'])->name('projetos.itens.promob.materiais.desvincular');
        Route::delete('/promob/limpar', [App\Http\Controllers\PromobImportController::class, 'limparImportacao'])->name('projetos.itens.promob.limpar');
    });
});

require __DIR__.'/auth.php';
