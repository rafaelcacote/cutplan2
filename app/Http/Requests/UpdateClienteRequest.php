<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClienteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nome' => 'required|string|max:150',
            'documento' => 'nullable|string|max:32',
            'email' => 'nullable|email|max:150',
            'telefone' => 'nullable|string|max:50',
            'observacoes' => 'nullable|string',
            // Endereço
            'endereco.linha1' => 'required|string|max:150',
            'endereco.linha2' => 'nullable|string|max:150',
            'endereco.cidade' => 'required|string|max:100',
            'endereco.estado' => 'required|string|max:100',
            'endereco.cep' => 'nullable|string|max:20',
            'endereco.pais' => 'required|string|max:100',
        ];
    }
}
