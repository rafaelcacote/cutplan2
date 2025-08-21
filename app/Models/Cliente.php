<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'documento',
        'email',
        'telefone',
        'endereco_id',
        'observacoes',
        'user_id',
    ];

    public function endereco()
    {
        return $this->belongsTo(Endereco::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
