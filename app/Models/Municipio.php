<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Municipio extends Model
{
    protected $table = 'municipios';
    public $timestamps = false;
    protected $fillable = ['nome', 'estado_id'];

    /**
     * Um município pertence a um estado.
     */
    public function estado(): BelongsTo
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }
}
