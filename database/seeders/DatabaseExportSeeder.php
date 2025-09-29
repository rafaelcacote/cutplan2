<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseExportSeeder extends Seeder
{
    public function run()
    {
    // Limpa a tabela de permissões de perfil
    DB::table('role_has_permissions')->truncate();

        // Usuários
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Admin',
                'cpf' => null,
                'email' => 'admin@admin.com',
                'email_verified_at' => null,
                'password' => '$2y$12$SOhFF9cmZSFz7xEa0X/ubeWB7VOUe1i.P8x7drl298MRP5M/A5zSq',
                'remember_token' => null,
                'created_at' => '2025-08-21 12:58:59',
                'updated_at' => '2025-08-21 12:58:59',
            ],
            [
                'id' => 2,
                'name' => 'Usuario teste',
                'cpf' => '58003108071',
                'email' => 'teste@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$i6wO.3vybk0tSnrWD7IhLurnpM2PXdnt6wXTa5GSZO9eGsgoFqVoi',
                'remember_token' => null,
                'created_at' => '2025-08-21 16:15:06',
                'updated_at' => '2025-08-21 16:15:06',
            ],
        ]);

        // Perfis (roles)
        DB::table('roles')->insert([
            [
                'id' => 1,
                'name' => 'Administrador',
                'guard_name' => 'web',
                'created_at' => '2025-08-21 12:58:59',
                'updated_at' => '2025-08-21 12:58:59',
            ],
            [
                'id' => 2,
                'name' => 'Consulta',
                'guard_name' => 'web',
                'created_at' => '2025-08-21 16:14:38',
                'updated_at' => '2025-08-21 16:14:38',
            ],
        ]);

        // Permissões
        DB::table('permissions')->insert([
            [
                'id' => 1,
                'name' => 'usuarios.listar',
                'guard_name' => 'web',
                'created_at' => '2025-08-21 12:58:59',
                'updated_at' => '2025-08-21 12:58:59',
            ],
            [
                'id' => 2,
                'name' => 'usuarios.visualizar',
                'guard_name' => 'web',
                'created_at' => '2025-08-21 12:58:59',
                'updated_at' => '2025-08-21 12:58:59',
            ],
            [
                'id' => 3,
                'name' => 'usuarios.criar',
                'guard_name' => 'web',
                'created_at' => '2025-08-21 12:58:59',
                'updated_at' => '2025-08-21 12:58:59',
            ],
            [
                'id' => 4,
                'name' => 'usuarios.editar',
                'guard_name' => 'web',
                'created_at' => '2025-08-21 12:58:59',
                'updated_at' => '2025-08-21 12:58:59',
            ],
            [
                'id' => 5,
                'name' => 'usuarios.excluir',
                'guard_name' => 'web',
                'created_at' => '2025-08-21 12:58:59',
                'updated_at' => '2025-08-21 12:58:59',
            ],
            [
                'id' => 6,
                'name' => 'perfis.listar',
                'guard_name' => 'web',
                'created_at' => '2025-08-21 12:58:59',
                'updated_at' => '2025-08-21 12:58:59',
            ],
            [
                'id' => 7,
                'name' => 'perfis.visualizar',
                'guard_name' => 'web',
                'created_at' => '2025-08-21 12:58:59',
                'updated_at' => '2025-08-21 12:58:59',
            ],
            [
                'id' => 8,
                'name' => 'perfis.criar',
                'guard_name' => 'web',
                'created_at' => '2025-08-21 12:58:59',
                'updated_at' => '2025-08-21 12:58:59',
            ],
            [
                'id' => 9,
                'name' => 'perfis.editar',
                'guard_name' => 'web',
                'created_at' => '2025-08-21 12:58:59',
                'updated_at' => '2025-08-21 12:58:59',
            ],
            [
                'id' => 10,
                'name' => 'perfis.excluir',
                'guard_name' => 'web',
                'created_at' => '2025-08-21 12:58:59',
                'updated_at' => '2025-08-21 12:58:59',
            ],
            [
                'id' => 11,
                'name' => 'permissoes.listar',
                'guard_name' => 'web',
                'created_at' => '2025-08-21 12:58:59',
                'updated_at' => '2025-08-21 12:58:59',
            ],
            [
                'id' => 12,
                'name' => 'permissoes.visualizar',
                'guard_name' => 'web',
                'created_at' => '2025-08-21 12:58:59',
                'updated_at' => '2025-08-21 12:58:59',
            ],
            [
                'id' => 13,
                'name' => 'permissoes.criar',
                'guard_name' => 'web',
                'created_at' => '2025-08-21 12:58:59',
                'updated_at' => '2025-08-21 12:58:59',
            ],
            [
                'id' => 14,
                'name' => 'permissoes.editar',
                'guard_name' => 'web',
                'created_at' => '2025-08-21 12:58:59',
                'updated_at' => '2025-08-21 12:58:59',
            ],
            [
                'id' => 15,
                'name' => 'permissoes.excluir',
                'guard_name' => 'web',
                'created_at' => '2025-08-21 12:58:59',
                'updated_at' => '2025-08-21 12:58:59',
            ],
            [
                'id' => 16,
                'name' => 'dashboard.acessar',
                'guard_name' => 'web',
                'created_at' => '2025-08-21 12:58:59',
                'updated_at' => '2025-08-21 12:58:59',
            ],
        ]);

        // Vínculos usuário-perfil (model_has_roles)
        DB::table('model_has_roles')->insert([
            [
                'role_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 1,
            ],
            [
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 2,
            ],
        ]);

        // Vínculos permissões-perfil (role_has_permissions)
        DB::table('role_has_permissions')->insert([
            ['permission_id' => 1, 'role_id' => 1],
            ['permission_id' => 2, 'role_id' => 1],
            ['permission_id' => 3, 'role_id' => 1],
            ['permission_id' => 4, 'role_id' => 1],
            ['permission_id' => 5, 'role_id' => 1],
            ['permission_id' => 6, 'role_id' => 1],
            ['permission_id' => 7, 'role_id' => 1],
            ['permission_id' => 8, 'role_id' => 1],
            ['permission_id' => 9, 'role_id' => 1],
            ['permission_id' => 10, 'role_id' => 1],
            ['permission_id' => 11, 'role_id' => 1],
            ['permission_id' => 12, 'role_id' => 1],
            ['permission_id' => 13, 'role_id' => 1],
            ['permission_id' => 14, 'role_id' => 1],
            ['permission_id' => 15, 'role_id' => 1],
            ['permission_id' => 16, 'role_id' => 1],
        ]);
    }
}
