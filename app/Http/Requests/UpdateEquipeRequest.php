<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEquipeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nome' => 'required|string|max:100',
            'descricao' => 'nullable|string',
            'lider_id' => 'required|exists:membros,id',
            'ativo' => 'boolean',
        ];
    }
}
