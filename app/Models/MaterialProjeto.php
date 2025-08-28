<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialProjeto extends Model
{
    use HasFactory;

    protected $table = 'materiais_projeto';

    protected $fillable = [
        'projeto_id',
        'material_id',
        'quantidade_necessaria',
        'quantidade_reservada',
        'quantidade_baixada',
        'observacoes',
    ];

    protected $casts = [
        'quantidade_necessaria' => 'decimal:4',
        'quantidade_reservada' => 'decimal:4',
        'quantidade_baixada' => 'decimal:4',
    ];

    // Relacionamentos
    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    // Accessors
    public function getQuantidadeFaltanteAttribute()
    {
        return $this->quantidade_necessaria - $this->quantidade_reservada;
    }

    public function getQuantidadePendenteAttribute()
    {
        return $this->quantidade_reservada - $this->quantidade_baixada;
    }

    public function getStatusAttribute()
    {
        if ($this->quantidade_baixada >= $this->quantidade_necessaria) {
            return 'baixado';
        } elseif ($this->quantidade_reservada >= $this->quantidade_necessaria) {
            return 'reservado';
        } elseif ($this->quantidade_reservada > 0) {
            return 'parcial';
        } else {
            return 'pendente';
        }
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'baixado' => 'Baixado',
            'reservado' => 'Reservado',
            'parcial' => 'Parcialmente Reservado',
            'pendente' => 'Pendente',
            default => 'Não definido'
        };
    }

    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'baixado' => 'badge bg-success',
            'reservado' => 'badge bg-info',
            'parcial' => 'badge bg-warning',
            'pendente' => 'badge bg-danger',
            default => 'badge bg-light'
        };
    }
}
