<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Membro extends Model
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
        'email',
        'telefone',
        'cargo_id',
        'ativo',
        'tenant_id',
    ];

    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function equipes()
    {
        return $this->belongsToMany(Equipe::class, 'membros_equipe', 'membro_id', 'equipe_id')->withPivot('funcao')->withTimestamps();
    }

    /**
     * Scope para filtrar membros por tenant
     */
    public function scopeForTenant($query, $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }
}
