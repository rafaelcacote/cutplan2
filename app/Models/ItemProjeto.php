<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ItemProjeto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'itens_projeto';

    protected $fillable = [
        'projeto_id',
        'item_orcamento_id',
        'descricao',
        'observacao',
        'quantidade',
        'unidade_id',
        'preco_orcado',
        'preco_real',
        'custo_materiais',
        'custo_mao_obra',
        'status',
        'data_inicio_prevista',
        'data_inicio_real',
        'data_conclusao_prevista',
        'data_conclusao_real',
        'percentual_concluido',
        'codigo_promob',
        'dados_promob_xml',
        'metadados_promob',
        'criado_por',
        'atualizado_por',
        // Campos do Promob
        'categoria',
        'subcategoria',
        'referencia',
        'familia',
        'grupo',
        'largura',
        'altura',
        'profundidade',
        'dimensoes_texto',
        'guid',
        'repeticao',
        'data_importacao_xml',
    ];

    protected $casts = [
        'quantidade' => 'decimal:3',
        'preco_orcado' => 'decimal:4',
        'preco_real' => 'decimal:4',
        'custo_materiais' => 'decimal:4',
        'custo_mao_obra' => 'decimal:4',
        'percentual_concluido' => 'decimal:2',
        'largura' => 'decimal:2',
        'altura' => 'decimal:2',
        'profundidade' => 'decimal:2',
        'repeticao' => 'integer',
        'data_inicio_prevista' => 'date',
        'data_inicio_real' => 'date',
        'data_conclusao_prevista' => 'date',
        'data_conclusao_real' => 'date',
        'data_importacao_xml' => 'datetime',
        'metadados_promob' => 'array',
    ];

    // Relacionamentos
    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }

    public function itemOrcamento()
    {
        return $this->belongsTo(ItemOrcamento::class);
    }

    public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }

    public function criadoPor()
    {
        return $this->belongsTo(User::class, 'criado_por');
    }

    public function atualizadoPor()
    {
        return $this->belongsTo(User::class, 'atualizado_por');
    }

    public function materiaisProjeto()
    {
        return $this->hasMany(MaterialProjeto::class);
    }

<<<<<<< HEAD
    public function materiaisPromob()
    {
        return $this->hasMany(MaterialItemProjeto::class);
=======
    public function materiaisItem()
    {
        return $this->hasMany(MaterialItemProjeto::class, 'item_projeto_id');
    }

    public function materiaisImportados()
    {
        return $this->materiaisItem()->where('origem', 'importacao');
    }

    public function materiaisManuais()
    {
        return $this->materiaisItem()->where('origem', 'manual');
>>>>>>> 7012bec986af49e4fe38c2a79df68e11c2fd8a81
    }

    // Accessors
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pendente' => 'Pendente',
            'em_andamento' => 'Em Andamento',
            'concluido' => 'Concluído',
            'cancelado' => 'Cancelado',
            default => $this->status
        };
    }

    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'pendente' => 'badge bg-secondary text-white',
            'em_andamento' => 'badge bg-primary text-white',
            'concluido' => 'badge bg-success text-white',
            'cancelado' => 'badge bg-danger text-white',
            default => 'badge bg-light text-dark'
        };
    }

    public function getCustoTotalAttribute()
    {
        return $this->custo_materiais + $this->custo_mao_obra;
    }

    public function getMargemAttribute()
    {
        if ($this->preco_real && $this->custo_total > 0) {
            return (($this->preco_real - $this->custo_total) / $this->preco_real) * 100;
        }
        return 0;
    }

    public function getDimensoesCompletasAttribute()
    {
        if ($this->dimensoes_texto) {
            return $this->dimensoes_texto;
        }
        
        $dimensoes = [];
        if ($this->largura) $dimensoes[] = "L: {$this->largura}";
        if ($this->altura) $dimensoes[] = "A: {$this->altura}";
        if ($this->profundidade) $dimensoes[] = "P: {$this->profundidade}";
        
        return implode(' x ', $dimensoes) ?: null;
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    public function scopeAtrasados($query)
    {
        return $query->where('data_conclusao_prevista', '<', now())
                    ->whereIn('status', ['pendente', 'em_andamento']);
    }

    public function scopeComPromob($query)
    {
        return $query->whereNotNull('codigo_promob');
    }

    // Métodos
    public function calcularCustoReal()
    {
        $this->custo_materiais = $this->materiaisProjeto->sum('custo_total');
        $this->save();
        
        return $this->custo_total;
    }

    public function atualizarProgresso($percentual)
    {
        $this->percentual_concluido = max(0, min(100, $percentual));
        
        if ($percentual >= 100) {
            $this->status = 'concluido';
            $this->data_conclusao_real = now();
        } elseif ($percentual > 0 && $this->status === 'pendente') {
            $this->status = 'em_andamento';
            $this->data_inicio_real = $this->data_inicio_real ?: now();
        }
        
        $this->save();
    }

    public function importarDadosPromob(array $dadosXml)
    {
        $this->fill([
            'categoria' => $dadosXml['categoria'] ?? null,
            'subcategoria' => $dadosXml['subcategoria'] ?? null,
            'referencia' => $dadosXml['referencia'] ?? null,
            'familia' => $dadosXml['familia'] ?? null,
            'grupo' => $dadosXml['grupo'] ?? null,
            'largura' => $dadosXml['largura'] ?? null,
            'altura' => $dadosXml['altura'] ?? null,
            'profundidade' => $dadosXml['profundidade'] ?? null,
            'dimensoes_texto' => $dadosXml['dimensoes_texto'] ?? null,
            'guid' => $dadosXml['guid'] ?? null,
            'repeticao' => $dadosXml['repeticao'] ?? 1,
            'metadados_promob' => $dadosXml,
            'data_importacao_xml' => now(),
        ]);
        
        $this->save();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            if (Auth::check()) {
                $item->criado_por = Auth::id();
            }
        });

        static::updating(function ($item) {
            if (Auth::check()) {
                $item->atualizado_por = Auth::id();
            }
        });
    }
}