<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    use HasFactory;
    
    protected $table = 'unidades';
    public $timestamps = false; // Tabela não tem timestamps
    
    protected $fillable = [
        'nome',
        'codigo',
        'precisao'
    ];

    public function itensOrcamento()
    {
        return $this->hasMany(ItemOrcamento::class);
    }
}
