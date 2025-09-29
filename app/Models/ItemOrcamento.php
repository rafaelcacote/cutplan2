<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemOrcamento extends Model
{
    use HasFactory;

    protected $table = 'itens_orcamento';

    // Desabilitar timestamps já que a tabela não tem essas colunas
    public $timestamps = false;

    protected $fillable = [
        'orcamento_id',
        'descricao',
        'observacao',
        'quantidade',
        'unidade_id',
        'preco_unitario',
        'total',
        'item_servico_id',
    ];

    protected $casts = [
        'quantidade' => 'decimal:4',
        'preco_unitario' => 'decimal:4',
        'total' => 'decimal:4',
    ];

    public function orcamento()
    {
        return $this->belongsTo(Orcamento::class);
    }

    public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }

    public function itemServico()
    {
        return $this->belongsTo(ItemServico::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
            $item->total = $item->quantidade * $item->preco_unitario;
        });

        static::saved(function ($item) {
            $item->orcamento->recalcularTotais();
        });

        static::deleted(function ($item) {
            $item->orcamento->recalcularTotais();
        });
    }
}
