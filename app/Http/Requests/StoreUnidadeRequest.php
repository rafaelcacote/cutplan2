<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnidadeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'codigo' => 'required|string|max:16|unique:unidades,codigo',
            'nome' => 'required|string|max:64',
            'precisao' => 'required|integer|min:0|max:10',
        ];
    }

    public function messages()
    {
        return [
            'codigo.required' => 'O código é obrigatório.',
            'codigo.unique' => 'Este código já está cadastrado.',
            'codigo.max' => 'O código deve ter no máximo 16 caracteres.',
            'nome.required' => 'O nome é obrigatório.',
            'nome.max' => 'O nome deve ter no máximo 64 caracteres.',
            'precisao.required' => 'A precisão é obrigatória.',
            'precisao.integer' => 'A precisão deve ser um número inteiro.',
            'precisao.min' => 'A precisão mínima é 0.',
            'precisao.max' => 'A precisão máxima é 10.',
        ];
    }
}
