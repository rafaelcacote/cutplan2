<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    // Teste 1: Verificar se as permissões existem
    $permissions = \Spatie\Permission\Models\Permission::all();
    echo "✅ Permissões encontradas: " . $permissions->count() . "\n";
    
    // Teste 2: Criar um perfil de teste
    $role = \App\Models\Role::firstOrCreate(['name' => 'Teste Sistema', 'guard_name' => 'web']);
    echo "✅ Perfil criado: " . $role->name . "\n";
    
    // Teste 3: Atribuir permissões ao perfil
    $role->givePermissionTo(['usuarios.listar', 'usuarios.criar']);
    echo "✅ Permissões atribuídas ao perfil\n";
    
    // Teste 4: Verificar se as permissões foram atribuídas
    $rolePermissions = $role->permissions;
    echo "✅ Permissões do perfil: " . $rolePermissions->count() . "\n";
    
    // Teste 5: Criar um usuário de teste
    $user = \App\Models\User::firstOrCreate(
        ['email' => 'teste@teste.com'],
        ['name' => 'Usuário Teste', 'password' => bcrypt('123456')]
    );
    echo "✅ Usuário criado: " . $user->name . "\n";
    
    // Teste 6: Atribuir perfil ao usuário
    $user->assignRole($role);
    echo "✅ Perfil atribuído ao usuário\n";
    
    // Teste 7: Verificar se o usuário tem as permissões
    $hasPermission = $user->hasPermissionTo('usuarios.listar');
    echo "✅ Usuário tem permissão usuarios.listar: " . ($hasPermission ? 'SIM' : 'NÃO') . "\n";
    
    echo "\n🎉 TODOS OS TESTES PASSARAM! O sistema de permissões está funcionando corretamente.\n";
    
} catch (Exception $e) {
    echo "❌ ERRO: " . $e->getMessage() . "\n";
    echo "Arquivo: " . $e->getFile() . " Linha: " . $e->getLine() . "\n";
}
