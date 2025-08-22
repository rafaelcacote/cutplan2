<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaterialRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nome' => 'required|string|max:150|unique:materiais,nome',
            'tipo_id' => 'required|exists:tipos_materiais,id',
            'unidade_id' => 'required|exists:unidades,id',
            'preco_custo' => 'nullable|numeric',
            'estoque_minimo' => 'nullable|numeric',
            'controla_estoque' => 'required|boolean',
            'ativo' => 'required|boolean',
        ];
    }
}
