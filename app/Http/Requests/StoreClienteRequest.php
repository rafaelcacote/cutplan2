<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nome' => 'required|string|max:150',
            'documento' => ['required', 'string', 'size:11', new \App\Rules\CpfRule(), 'unique:clientes,documento'],
            'email' => 'nullable|email|max:100',
            'telefone' => 'nullable|string|max:20',
            'observacoes' => 'nullable|string',
            // Endereço obrigatório
            'endereco.endereco' => 'required|string|max:150',
            'endereco.numero' => 'required|string|max:10',
            'endereco.bairro' => 'required|string|max:45',
            'endereco.municipio_id' => 'required|exists:municipios,id',
            'endereco.cep' => 'nullable|string|max:20',
            'endereco.complemento' => 'nullable|string|max:150',
            'endereco.referencia' => 'nullable|string|max:255',
        ];
    }

        public function messages()
    {
        return [
            'nome.required' => 'O nome é obrigatório.',
            'nome.max' => 'O nome não pode ter mais que 150 caracteres.',
            'documento.required' => 'O CPF é obrigatório.',
            'documento.size' => 'O CPF deve ter 11 dígitos.',
            'documento.unique' => 'Este CPF já está cadastrado.',
            'documento.string' => 'O CPF deve ser um texto.',
            'email.email' => 'Informe um e-mail válido.',
            'email.max' => 'O e-mail não pode ter mais que 100 caracteres.',
            'telefone.max' => 'O telefone não pode ter mais que 20 caracteres.',
            'endereco.endereco.required' => 'O endereço é obrigatório.',
            'endereco.endereco.max' => 'O endereço não pode ter mais que 150 caracteres.',
            'endereco.numero.required' => 'O número é obrigatório.',
            'endereco.numero.max' => 'O número não pode ter mais que 10 caracteres.',
            'endereco.bairro.required' => 'O bairro é obrigatório.',
            'endereco.bairro.max' => 'O bairro não pode ter mais que 45 caracteres.',
            'endereco.municipio_id.required' => 'O município é obrigatório.',
            'endereco.municipio_id.exists' => 'Selecione um município válido.',
        ];
    }
}
