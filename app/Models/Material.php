<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'materiais';

    protected $fillable = [
        'nome',
        'tipo_id',
        'unidade_id',
        'preco_custo',
        'estoque_minimo',
        'controla_estoque',
        'ativo',
        'user_id',
    ];

    public function tipo()
    {
        return $this->belongsTo(TipoMaterial::class, 'tipo_id');
    }

    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'unidade_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
