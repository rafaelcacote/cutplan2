<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            'usuarios' => ['listar', 'visualizar', 'criar', 'editar', 'excluir'],
            'perfis' => ['listar', 'visualizar', 'criar', 'editar', 'excluir'],
            'permissoes' => ['listar', 'visualizar', 'criar', 'editar', 'excluir'],
            'tenants' => ['listar', 'ver', 'criar', 'editar', 'excluir'],
            'dashboard' => ['acessar'],
        ];

        foreach ($modules as $module => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => "$module.$action",
                    'guard_name' => 'web',
                ]);
            }
        }
    }
}
