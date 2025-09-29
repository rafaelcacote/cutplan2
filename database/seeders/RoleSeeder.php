<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {

        \DB::table('roles')->insert([
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
    }
}
