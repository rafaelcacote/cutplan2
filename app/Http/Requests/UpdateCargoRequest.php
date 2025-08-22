<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCargoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $cargoId = $this->route('cargo')->id ?? null;
        return [
            'nome' => 'required|string|max:100|unique:cargos,nome,' . $cargoId,
            'descricao' => 'nullable|string',
            'ativo' => 'boolean',
        ];
    }
}
