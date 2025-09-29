<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialItemProjeto extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $table = 'materiais_item_projeto';

    protected $fillable = [
        'item_projeto_id',
        'id_promob',
        'descricao',
        'referencia',
        'unidade',
        'quantidade',
        'repeticao',
        'largura',
        'altura',
        'profundidade',
        'dimensoes_texto',
        'categoria',
        'subcategoria',
        'familia',
        'grupo',
        'guid',
        'unique_id',
        'component',
        'structure',
        'observacoes',
        'xml_data',
        'metadados',
        'arquivo_xml_nome',
        'data_importacao',
        'importado_por',
=======
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
>>>>>>> 7012bec986af49e4fe38c2a79df68e11c2fd8a81
    ];

    protected $casts = [
        'quantidade' => 'decimal:4',
        'largura' => 'decimal:2',
        'altura' => 'decimal:2',
        'profundidade' => 'decimal:2',
<<<<<<< HEAD
        'repeticao' => 'integer',
        'metadados' => 'array',
        'data_importacao' => 'datetime',
=======
>>>>>>> 7012bec986af49e4fe38c2a79df68e11c2fd8a81
    ];

    // Relacionamentos
    public function itemProjeto()
    {
<<<<<<< HEAD
        return $this->belongsTo(ItemProjeto::class);
    }

    public function importadoPor()
    {
        return $this->belongsTo(User::class, 'importado_por');
    }

    // Accessors
    public function getDimensoesCompletasAttribute()
    {
        if ($this->dimensoes_texto) {
            return $this->dimensoes_texto;
        }
        
        $dimensoes = [];
        if ($this->largura) $dimensoes[] = "L: {$this->largura}mm";
        if ($this->altura) $dimensoes[] = "A: {$this->altura}mm";
        if ($this->profundidade) $dimensoes[] = "P: {$this->profundidade}mm";
        
        return implode(' x ', $dimensoes) ?: null;
    }

    public function getQuantidadeTotalAttribute()
    {
        return $this->quantidade * $this->repeticao;
    }

    public function getTipoComponenteAttribute()
    {
        if ($this->component === 'Y') return 'Componente';
        if ($this->structure === 'Y') return 'Estrutura';
        return 'Material';
    }

    // Scopes
    public function scopeByCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    public function scopeByFamilia($query, $familia)
    {
        return $query->where('familia', $familia);
    }

    public function scopeComponentes($query)
    {
        return $query->where('component', 'Y');
    }

    public function scopeEstrutura($query)
    {
        return $query->where('structure', 'Y');
    }
}
=======
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
>>>>>>> 7012bec986af49e4fe38c2a79df68e11c2fd8a81
