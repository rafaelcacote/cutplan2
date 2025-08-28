<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contrato extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'projeto_id',
        'numero',
        'titulo',
        'descricao',
        'valor',
        'data_inicio',
        'data_vencimento',
        'status',
        'arquivo_path',
        'observacoes',
    ];

    protected $casts = [
        'valor' => 'decimal:4',
        'data_inicio' => 'date',
        'data_vencimento' => 'date',
    ];

    // Relacionamentos
    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }

    // Accessors
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'rascunho' => 'Rascunho',
            'pendente_assinatura' => 'Pendente Assinatura',
            'assinado' => 'Assinado',
            'vigente' => 'Vigente',
            'vencido' => 'Vencido',
            'cancelado' => 'Cancelado',
            default => $this->status
        };
    }

    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'rascunho' => 'badge bg-secondary',
            'pendente_assinatura' => 'badge bg-warning',
            'assinado' => 'badge bg-info',
            'vigente' => 'badge bg-success',
            'vencido' => 'badge bg-danger',
            'cancelado' => 'badge bg-dark',
            default => 'badge bg-light'
        };
    }

    public function getTemArquivoAttribute()
    {
        return !empty($this->arquivo_path) && file_exists(storage_path('app/' . $this->arquivo_path));
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeVigentes($query)
    {
        return $query->where('status', 'vigente')
                    ->where('data_vencimento', '>=', now()->toDateString());
    }

    public function scopeVencidos($query)
    {
        return $query->where('data_vencimento', '<', now()->toDateString());
    }
}
