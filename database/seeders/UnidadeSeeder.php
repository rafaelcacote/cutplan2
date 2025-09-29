<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('unidades')->insert([
            ['id' => 1, 'codigo' => 'un', 'nome' => 'Unidade', 'precisao' => 0],
            ['id' => 2, 'codigo' => 'm', 'nome' => 'Metro', 'precisao' => 3],
            ['id' => 3, 'codigo' => 'ml', 'nome' => 'Mililitro', 'precisao' => 0],
            ['id' => 4, 'codigo' => 'kg', 'nome' => 'Quilo', 'precisao' => 3],
            ['id' => 5, 'codigo' => 'min', 'nome' => 'Minuto', 'precisao' => 0],
            ['id' => 6, 'codigo' => 'dia', 'nome' => 'Diária', 'precisao' => 0],
        ]);
    }
}
