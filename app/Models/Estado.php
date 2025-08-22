<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estado extends Model
{
    protected $table = 'estados';
    public $timestamps = false;
    protected $fillable = ['nome', 'uf'];

    /**
     * Um estado possui muitos municípios.
     */
    public function municipios(): HasMany
    {
        return $this->hasMany(Municipio::class, 'estado_id');
    }
}
