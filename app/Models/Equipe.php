<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipe extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'descricao',
        'lider_id',
        'ativo',
    ];

    public function lider()
    {
        return $this->belongsTo(Membro::class, 'lider_id');
    }

    public function membros()
    {
        return $this->belongsToMany(Membro::class, 'membros_equipe', 'equipe_id', 'membro_id')->withPivot('funcao')->withTimestamps();
    }
}
