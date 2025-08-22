<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCargoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nome' => 'required|string|max:100|unique:cargos,nome',
            'descricao' => 'nullable|string',
            'ativo' => 'boolean',
        ];
    }
}
