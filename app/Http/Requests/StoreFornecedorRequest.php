<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CpfCnpjRule;
use Illuminate\Validation\Rule;

class StoreFornecedorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->has('documento') && !empty($this->documento)) {
            $this->merge([
                'documento' => preg_replace('/[^0-9]/', '', $this->documento)
            ]);
        }
    }

    public function rules()
    {
        return [
            'nome' => 'required|string|max:150',
            'documento' => ['nullable', 'string', 'max:32', 'unique:fornecedores,documento', new CpfCnpjRule()],
            'email' => 'nullable|email|max:150',
            'telefone' => 'nullable|string|max:50',
            'endereco.endereco' => 'required|string',
            'endereco.numero' => 'required|string',
            'endereco.complemento' => 'nullable|string',
            'endereco.bairro' => 'required|string',
            'endereco.municipio_id' => 'required|exists:municipios,id',
            'endereco.cep' => 'required|string',
            'endereco.referencia' => 'nullable|string',
            'observacoes' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'documento.unique' => 'Este CPF/CNPJ já está cadastrado no sistema.',
            'nome.required' => 'O campo nome é obrigatório.',
            'endereco.endereco.required' => 'O campo endereço é obrigatório.',
            'endereco.numero.required' => 'O campo número é obrigatório.',
            'endereco.bairro.required' => 'O campo bairro é obrigatório.',
            'endereco.municipio_id.required' => 'O campo município é obrigatório.',
            'endereco.cep.required' => 'O campo CEP é obrigatório.',
        ];
    }
}
