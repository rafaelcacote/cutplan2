<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;
use App\Models\Endereco;
use App\Models\Servico;
use App\Models\ItemServico;
use App\Models\Unidade;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // Criar unidades básicas
        $unidades = [
            ['nome' => 'Unidade', 'codigo' => 'un', 'precisao' => 0],
            ['nome' => 'Metro', 'codigo' => 'm', 'precisao' => 2],
            ['nome' => 'Litro', 'codigo' => 'l', 'precisao' => 2],
        ];

        foreach ($unidades as $unidade) {
            Unidade::firstOrCreate(['codigo' => $unidade['codigo']], $unidade);
        }

        // Criar cliente de teste simples
        $endereco = Endereco::firstOrCreate([
            'cep' => '12345678'
        ], [
            'cep' => '12345678',
            'municipio_id' => 1, // Assumindo que existe
            'estado_id' => 1     // Assumindo que existe
        ]);

        $cliente = Cliente::firstOrCreate([
            'email' => 'cliente@teste.com'
        ], [
            'nome' => 'Cliente Teste',
            'documento' => '123.456.789-00',
            'telefone' => '(11) 99999-9999',
            'endereco_id' => $endereco->id
        ]);

        // Criar serviços de teste
        $servicoPintura = Servico::firstOrCreate(['nome' => 'Pintura de Sala'], [
            'ativo' => true
        ]);

        // Criar itens de serviço
        $itensPintura = [
            'Preparação das paredes',
            'Aplicação de tinta',
            'Acabamento'
        ];

        foreach ($itensPintura as $item) {
            ItemServico::firstOrCreate([
                'servico_id' => $servicoPintura->id,
                'descricao_item' => $item
            ]);
        }

        $this->command->info('Dados de teste criados com sucesso!');
    }
}
