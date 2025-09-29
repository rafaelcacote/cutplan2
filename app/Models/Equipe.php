<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Equipe extends Model
{
    use HasFactory, SoftDeletes;

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
        'descricao',
        'lider_id',
        'ativo',
        'tenant_id',
    ];

    public function lider()
    {
        return $this->belongsTo(Membro::class, 'lider_id');
    }

    public function membros()
    {
        return $this->belongsToMany(Membro::class, 'membros_equipe', 'equipe_id', 'membro_id')->withPivot('funcao')->withTimestamps();
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Scope para filtrar equipes por tenant
     */
    public function scopeForTenant($query, $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }
}
