<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMembroRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nome' => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'telefone' => 'nullable|string|max:20',
            'cargo_id' => 'required|exists:cargos,id',
            'ativo' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O nome é obrigatório.',
            'nome.max' => 'O nome não pode ter mais que 100 caracteres.',
            'email.email' => 'Informe um e-mail válido.',
            'email.max' => 'O e-mail não pode ter mais que 100 caracteres.',
            'telefone.max' => 'O telefone não pode ter mais que 20 caracteres.',
            'cargo_id.required' => 'O cargo é obrigatório.',
            'cargo_id.exists' => 'Selecione um cargo válido.',
        ];
    }
}
