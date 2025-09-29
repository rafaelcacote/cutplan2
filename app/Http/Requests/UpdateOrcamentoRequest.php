<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrcamentoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cliente_id' => 'required|exists:clientes,id',
            'status' => 'required|in:draft,awaiting,sent,approved,rejected,expired',
            'validade' => 'nullable|date',
            'desconto' => 'nullable|numeric|min:0',
            'observacoes' => 'nullable|string|max:1000',
            'itens' => 'required|array|min:1',
            'itens.*.descricao' => 'required|string|max:255',
            'itens.*.quantidade' => 'required|numeric|min:0.01',
            'itens.*.unidade_id' => 'nullable|exists:unidades,id',
            'itens.*.preco_unitario' => 'required|numeric|min:0.01',
            'itens.*.item_servico_id' => 'nullable|exists:itens_servico,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'cliente_id.required' => 'É obrigatório selecionar um cliente.',
            'cliente_id.exists' => 'Cliente selecionado não é válido.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'Status selecionado não é válido.',
            'validade.date' => 'Data de validade deve ser uma data válida.',
            'desconto.min' => 'O desconto não pode ser negativo.',
            'itens.required' => 'É obrigatório adicionar pelo menos um item ao orçamento.',
            'itens.min' => 'É obrigatório adicionar pelo menos um item ao orçamento.',
            'itens.*.descricao.required' => 'A descrição do item é obrigatória.',
            'itens.*.descricao.max' => 'A descrição do item não pode ter mais de 255 caracteres.',
            'itens.*.quantidade.required' => 'A quantidade é obrigatória.',
            'itens.*.quantidade.min' => 'A quantidade deve ser maior que zero.',
            'itens.*.preco_unitario.required' => 'O preço unitário é obrigatório.',
            'itens.*.preco_unitario.min' => 'O preço unitário deve ser maior que zero.',
            'itens.*.unidade_id.exists' => 'Unidade selecionada não é válida.',
            'itens.*.item_servico_id.exists' => 'Item de serviço selecionado não é válido.',
        ];
    }
}
