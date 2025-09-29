<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoMaterial extends Model
{
    use HasFactory;
    
    protected $table = 'tipos_materiais';
    protected $fillable = ['nome'];
    public $timestamps = false; // A tabela não tem timestamps
}
