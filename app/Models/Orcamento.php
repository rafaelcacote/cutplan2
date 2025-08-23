<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orcamento extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cliente_id',
        'status',
        'subtotal',
        'desconto',
        'total',
        'validade',
        'user_id',
        'observacoes',
    ];

    protected $casts = [
        'validade' => 'date',
        'subtotal' => 'decimal:4',
        'desconto' => 'decimal:4',
        'total' => 'decimal:4',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function itens()
    {
        return $this->hasMany(ItemOrcamento::class);
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'draft' => 'Rascunho',
            'sent' => 'Enviado',
            'approved' => 'Aprovado',
            'rejected' => 'Rejeitado',
            'expired' => 'Expirado',
            default => 'Desconhecido'
        };
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'draft' => 'bg-secondary',
            'sent' => 'bg-primary',
            'approved' => 'bg-success',
            'rejected' => 'bg-danger',
            'expired' => 'bg-warning',
            default => 'bg-secondary'
        };
    }

    public function recalcularTotais()
    {
        $this->subtotal = $this->itens()->sum('total');
        $this->total = $this->subtotal - $this->desconto;
        $this->save();
    }
}
