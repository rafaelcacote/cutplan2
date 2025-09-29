<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoMaterialSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tipos_materiais')->insert([
            ['id' => 1, 'nome' => 'chapa'],
            ['id' => 2, 'nome' => 'ferragem'],
            ['id' => 3, 'nome' => 'consumivel'],
            ['id' => 4, 'nome' => 'EPI'],
            ['id' => 5, 'nome' => 'ferramenta'],
            ['id' => 6, 'nome' => 'maquina'],
            ['id' => 7, 'nome' => 'tinta'],
            ['id' => 8, 'nome' => 'servico'],
        ]);
    }
}
