<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Endereco extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'linha1',
        'linha2',
        'cidade',
        'estado',
        'cep',
        'pais',
    ];

    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }
}
