<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Projeto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'codigo',
        'cliente_id',
        'nome',
        'status',
        'data_inicio',
        'data_entrega_prevista',
        'data_entrega_real',
        'gerente_user_id',
        'endereco_instalacao_id',
        'observacoes',
        'equipe_id',
        'orcamento_id',
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_entrega_prevista' => 'date',
        'data_entrega_real' => 'date',
    ];

    // Relacionamentos
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function orcamento()
    {
        return $this->belongsTo(Orcamento::class);
    }

    public function gerente()
    {
        return $this->belongsTo(User::class, 'gerente_user_id');
    }

    public function enderecoInstalacao()
    {
        return $this->belongsTo(Endereco::class, 'endereco_instalacao_id');
    }

    public function equipe()
    {
        return $this->belongsTo(Equipe::class);
    }

    public function materiaisProjeto()
    {
        return $this->hasMany(MaterialProjeto::class);
    }

    public function contratos()
    {
        return $this->hasMany(Contrato::class);
    }

    // Accessors
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'em_planejamento' => 'Em Planejamento',
            'producao' => 'Produção',
            'montagem' => 'Montagem',
            'vistoria' => 'Vistoria',
            'concluido' => 'Concluído',
            'cancelado' => 'Cancelado',
            default => $this->status
        };
    }

    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'em_planejamento' => 'badge bg-secondary',
            'producao' => 'badge bg-primary',
            'montagem' => 'badge bg-info',
            'vistoria' => 'badge bg-warning',
            'concluido' => 'badge bg-success',
            'cancelado' => 'badge bg-danger',
            default => 'badge bg-light'
        };
    }

    // Scopes
    public function scopeByCliente($query, $clienteId)
    {
        return $query->where('cliente_id', $clienteId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPeriodo($query, $dataInicio, $dataFim)
    {
        return $query->whereBetween('data_inicio', [$dataInicio, $dataFim]);
    }

    // Métodos
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($projeto) {
            if (empty($projeto->codigo)) {
                $projeto->codigo = static::generateCodigo();
            }
        });
    }

    public static function generateCodigo()
    {
        $ano = date('Y');
        $ultimoProjeto = static::whereYear('created_at', $ano)
            ->orderBy('id', 'desc')
            ->first();

        $numero = $ultimoProjeto ? ((int) substr($ultimoProjeto->codigo, -4)) + 1 : 1;

        return 'PRJ' . $ano . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }
}
