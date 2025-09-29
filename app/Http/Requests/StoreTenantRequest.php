<?php

namespace App\Http\Requests;

use App\Rules\CpfCnpjRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTenantRequest extends FormRequest
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
            'nome' => 'required|string|max:150',
            'cnpj' => ['nullable', 'string', new CpfCnpjRule(), 'unique:tenants,cnpj'],
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:150',
            'slug' => 'nullable|string|max:60|unique:tenants,slug',
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

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nome.required' => 'O nome da empresa é obrigatório.',
            'nome.string' => 'O nome da empresa deve ser um texto válido.',
            'nome.max' => 'O nome da empresa não pode ter mais de 150 caracteres.',
            
            'cnpj.unique' => 'Este CNPJ já está sendo usado por outra empresa.',
            
            'logo.image' => 'O logo deve ser uma imagem.',
            'logo.mimes' => 'O logo deve ser um arquivo do tipo: jpeg, png, jpg, gif.',
            'logo.max' => 'O logo não pode ser maior que 2MB.',
            
            'endereco.endereco.required' => 'O endereço é obrigatório.',
            'endereco.endereco.max' => 'O endereço não pode ter mais de 150 caracteres.',
            'endereco.numero.required' => 'O número é obrigatório.',
            'endereco.numero.max' => 'O número não pode ter mais de 10 caracteres.',
            'endereco.bairro.required' => 'O bairro é obrigatório.',
            'endereco.bairro.max' => 'O bairro não pode ter mais de 45 caracteres.',
            'endereco.municipio_id.required' => 'O município é obrigatório.',
            'endereco.municipio_id.exists' => 'Selecione um município válido.',
            
            'telefone.string' => 'O telefone deve ser um texto válido.',
            'telefone.max' => 'O telefone não pode ter mais de 20 caracteres.',
            
            'email.email' => 'O e-mail deve ter um formato válido.',
            'email.max' => 'O e-mail não pode ter mais de 150 caracteres.',
            
            'slug.string' => 'O slug deve ser um texto válido.',
            'slug.max' => 'O slug não pode ter mais de 60 caracteres.',
            'slug.unique' => 'Este slug já está sendo usado por outra empresa.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'nome' => 'nome da empresa',
            'cnpj' => 'CNPJ',
            'logo' => 'logo',
            'endereco' => 'endereço',
            'telefone' => 'telefone',
            'email' => 'e-mail',
            'slug' => 'slug',
        ];
    }
}