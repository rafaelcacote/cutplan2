<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateItemServicoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $itemId = $this->route('itens_servico') ? $this->route('itens_servico')->id : null;
        
        return [
            'descricao_item' => [
                'required',
                'string',
                'max:255',
                Rule::unique('itens_servico', 'descricao_item')
                    ->where('servico_id', $this->servico_id)
                    ->ignore($itemId)
            ],
            'servico_id' => 'required|exists:servicos,id',
        ];
    }

    public function messages(): array
    {
        return [
            'descricao_item.required' => 'A descrição do item é obrigatória.',
            'descricao_item.unique' => 'Já existe um item com esta descrição neste serviço.',
            'servico_id.required' => 'O serviço é obrigatório.',
            'servico_id.exists' => 'O serviço selecionado não existe.',
        ];
    }
}
