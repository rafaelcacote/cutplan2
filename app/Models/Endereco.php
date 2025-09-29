<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Endereco extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'municipio_id',
        'cep',
        'referencia',
    ];

    /**
     * Um endereço pertence a um município.
     */
    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'municipio_id');
    }

    /**
     * Um endereço pertence a um estado (através do município).
     */
    public function estado()
    {
        return $this->hasOneThrough(Estado::class, Municipio::class, 'id', 'id', 'municipio_id', 'estado_id');
    }
}
