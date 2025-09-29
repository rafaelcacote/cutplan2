<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Projeto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
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

    public function itensProjeto()
    {
        return $this->hasMany(ItemProjeto::class);
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
        
        // Código removido: não precisamos mais gerar código automaticamente
    }

    /**
     * Cria itens do projeto a partir dos itens do orçamento
     */
    public function criarItensDoOrcamento()
    {
        if (!$this->orcamento) {
            return false;
        }

        // Evitar duplicação - verificar se já existem itens
        if ($this->itensProjeto()->count() > 0) {
            return false;
        }

        $itensCreated = 0;

        foreach ($this->orcamento->itens as $itemOrcamento) {
            ItemProjeto::create([
                'projeto_id' => $this->id,
                'item_orcamento_id' => $itemOrcamento->id,
                'descricao' => $itemOrcamento->descricao,
                'observacao' => $itemOrcamento->observacao,
                'quantidade' => $itemOrcamento->quantidade,
                'unidade_id' => $itemOrcamento->unidade_id,
                'preco_orcado' => $itemOrcamento->preco_unitario,
                'status' => 'pendente',
                'data_conclusao_prevista' => $this->data_entrega_prevista,
                'criado_por' => Auth::id() ?? 1, // Usuário logado ou padrão
            ]);
            $itensCreated++;
        }

        return $itensCreated;
    }

    /**
     * Calcula o percentual de conclusão do projeto baseado nos itens
     */
    public function calcularProgressoGeral()
    {
        $itens = $this->itensProjeto;
        
        if ($itens->count() === 0) {
            return 0;
        }

        $progressoTotal = $itens->sum('percentual_concluido');
        return round($progressoTotal / $itens->count(), 2);
    }

    /**
     * Calcula o custo real total do projeto
     */
    public function calcularCustoReal()
    {
        return $this->itensProjeto->sum(function ($item) {
            return $item->custo_total;
        });
    }

    /**
     * Calcula a margem do projeto
     */
    public function calcularMargem()
    {
        $precoOrcado = $this->orcamento ? $this->orcamento->total : 0;
        $custoReal = $this->calcularCustoReal();
        
        if ($precoOrcado > 0) {
            return (($precoOrcado - $custoReal) / $precoOrcado) * 100;
        }
        
        return 0;
    }

    
}
