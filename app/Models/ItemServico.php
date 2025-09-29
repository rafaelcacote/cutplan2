<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemServico extends Model
{
    use HasFactory;

    protected $table = 'itens_servico';

    protected $fillable = [
        'descricao_item',
        'servico_id',
    ];

    public function servico()
    {
        return $this->belongsTo(Servico::class);
    }
}
