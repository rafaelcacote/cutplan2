<?php

namespace App\Http\Requests;

use App\Rules\CpfRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $userId = $this->route('user')->id;
        
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userId,
            'cpf' => ['nullable', 'string', new CpfRule(), 'unique:users,cpf,' . $userId],
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'nullable|string|exists:roles,name',
            'tenant_id' => 'nullable|exists:tenants,id',
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
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser um texto válido.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ter um formato válido.',
            'email.unique' => 'Este e-mail já está sendo usado por outro usuário.',
            
            'cpf.unique' => 'Este CPF já está sendo usado por outro usuário.',
            
            'password.string' => 'A senha deve ser um texto válido.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
            'password.confirmed' => 'A confirmação da senha não confere.',
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
            'name' => 'nome',
            'email' => 'e-mail',
            'cpf' => 'CPF',
            'password' => 'senha',
            'password_confirmation' => 'confirmação da senha',
        ];
    }
}
