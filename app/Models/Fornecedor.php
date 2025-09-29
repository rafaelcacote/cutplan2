<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;



class Fornecedor extends Model
{
    protected $primaryKey = 'id';

    use HasFactory, SoftDeletes;
    protected $table = 'fornecedores';
    
    public function getRouteKeyName()
    {
        return 'id';
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            if (auth()->check() && auth()->user()->tenant_id) {
                $builder->where('tenant_id', auth()->user()->tenant_id);
            }
        });
    }

    protected $fillable = [
        'nome',
        'documento',
        'email',
        'telefone',
        'endereco_id',
        'user_id',
        'tenant_id',
        'observacoes',
    ];

    // Mutator: Remove caracteres especiais antes de salvar
    public function setDocumentoAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['documento'] = preg_replace('/[^0-9]/', '', $value);
        } else {
            $this->attributes['documento'] = null;
        }
    }

    // Accessor: Aplica máscara ao exibir
    public function getDocumentoFormatadoAttribute()
    {
        if (empty($this->documento)) {
            return null;
        }
        
        $documento = $this->documento;
        
        if (strlen($documento) == 11) {
            // CPF: 000.000.000-00
            return substr($documento, 0, 3) . '.' . 
                   substr($documento, 3, 3) . '.' . 
                   substr($documento, 6, 3) . '-' . 
                   substr($documento, 9, 2);
        } elseif (strlen($documento) == 14) {
            // CNPJ: 00.000.000/0000-00
            return substr($documento, 0, 2) . '.' . 
                   substr($documento, 2, 3) . '.' . 
                   substr($documento, 5, 3) . '/' . 
                   substr($documento, 8, 4) . '-' . 
                   substr($documento, 12, 2);
        }
        
        return $documento;
    }

    public function endereco()
    {
        return $this->belongsTo(Endereco::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Scope para filtrar fornecedores por tenant
     */
    public function scopeForTenant($query, $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }
}
