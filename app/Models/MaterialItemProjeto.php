<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialItemProjeto extends Model
{
    use HasFactory;

    protected $table = 'materiais_itens_projeto';

    protected $fillable = [
        'item_projeto_id',
        'material_id',
        'codigo_promob',
        'descricao',
        'unidade',
        'quantidade',
        'largura',
        'altura',
        'profundidade',
        'familia',
        'grupo',
        'imagem',
        'origem',
    ];

    protected $casts = [
        'quantidade' => 'decimal:4',
        'largura' => 'decimal:2',
        'altura' => 'decimal:2',
        'profundidade' => 'decimal:2',
    ];

    // Relacionamentos
    public function itemProjeto()
    {
        return $this->belongsTo(ItemProjeto::class, 'item_projeto_id');
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    // Scopes
    public function scopeImportados($query)
    {
        return $query->where('origem', 'importacao');
    }

    public function scopeManuais($query)
    {
        return $query->where('origem', 'manual');
    }

    // Accessors
    public function getVolumeTotalAttribute()
    {
        if ($this->largura && $this->altura && $this->profundidade) {
            return $this->largura * $this->altura * $this->profundidade * $this->quantidade;
        }
        return null;
    }

    public function getAreaTotalAttribute()
    {
        if ($this->largura && $this->altura) {
            return $this->largura * $this->altura * $this->quantidade;
        }
        return null;
    }

    public function getTemMaterialVinculadoAttribute()
    {
        return !is_null($this->material_id);
    }
}