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
        'uuid',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = \Illuminate\Support\Str::uuid();
            }
        });
    }

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

    public function projetos()
    {
        return $this->hasMany(Projeto::class);
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'draft' => 'Rascunho',
            'awaiting' => 'Aguardando',
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
            'draft' => 'bg-secondary text-white',
            'awaiting' => 'bg-warning text-dark',
            'sent' => 'bg-primary text-white',
            'approved' => 'bg-success text-white',
            'rejected' => 'bg-danger text-white',
            'expired' => 'bg-warning text-dark',
            default => 'bg-secondary text-white'
        };
    }

    public function recalcularTotais()
    {
        $this->subtotal = $this->itens()->sum('total');
        $this->total = $this->subtotal - $this->desconto;
        $this->save();
    }

    public function temProjetoCriado()
    {
        return $this->projetos()->exists();
    }

    public function getPrimeiroProjeto()
    {
        return $this->projetos()->first();
    }

    public function podeSerExcluido()
    {
        return in_array($this->status, ['draft', 'awaiting', 'rejected', 'expired']);
    }
}
