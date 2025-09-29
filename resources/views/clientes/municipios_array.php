<?php
// Este arquivo retorna um array de municípios agrupados por estado para uso no JS do formulário de clientes
use App\Models\Municipio;

$municipios = Municipio::all()->groupBy('estado_id')->map(function($group) {
    return $group->map(function($m) {
        return ['id' => $m->id, 'nome' => $m->nome];
    });
});
return $municipios;
