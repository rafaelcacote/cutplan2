<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tenant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'cnpj',
        'logo',
        'endereco_id',
        'telefone',
        'email',
        'slug',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tenant) {
            if (empty($tenant->slug)) {
                $tenant->slug = Str::slug($tenant->nome);
                
                // Garantir que o slug seja único
                $originalSlug = $tenant->slug;
                $count = 1;
                
                while (static::where('slug', $tenant->slug)->exists()) {
                    $tenant->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
        });

        static::updating(function ($tenant) {
            if ($tenant->isDirty('nome') && empty($tenant->getOriginal('slug'))) {
                $tenant->slug = Str::slug($tenant->nome);
                
                // Garantir que o slug seja único
                $originalSlug = $tenant->slug;
                $count = 1;
                
                while (static::where('slug', $tenant->slug)->where('id', '!=', $tenant->id)->exists()) {
                    $tenant->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
        });
    }

    /**
     * Relacionamento com usuários
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Relacionamento com endereço
     */
    public function endereco()
    {
        return $this->belongsTo(Endereco::class);
    }

    /**
     * Get the formatted CNPJ attribute.
     */
    public function getFormattedCnpjAttribute(): ?string
    {
        if (!$this->cnpj) {
            return null;
        }

        $cnpj = preg_replace('/[^0-9]/', '', $this->cnpj);
        
        if (strlen($cnpj) == 14) {
            return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $cnpj);
        }

        return $this->cnpj;
    }

    /**
     * Get the formatted phone attribute.
     */
    public function getFormattedTelefoneAttribute(): ?string
    {
        if (!$this->telefone) {
            return null;
        }

        $telefone = preg_replace('/[^0-9]/', '', $this->telefone);
        
        if (strlen($telefone) == 11) {
            return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $telefone);
        } elseif (strlen($telefone) == 10) {
            return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $telefone);
        }

        return $this->telefone;
    }
}