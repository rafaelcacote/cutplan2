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
        $tenantId = auth()->user()->tenant_id;
        
        return [
            'nome' => [
                'required',
                'string',
                'max:150',
                function ($attribute, $value, $fail) use ($tenantId) {
                    $exists = \App\Models\Material::withoutGlobalScope('tenant')
                        ->where('nome', $value)
                        ->where('tenant_id', $tenantId)
                        ->exists();
                    
                    if ($exists) {
                        $fail('O nome do material já existe para esta empresa.');
                    }
                }
            ],
            'tipo_id' => 'required|exists:tipos_materiais,id',
            'unidade_id' => 'required|exists:unidades,id',
            'preco_custo' => 'nullable|numeric',
            'estoque_minimo' => 'nullable|numeric',
            'controla_estoque' => 'required|boolean',
            'ativo' => 'required|boolean',
        ];
    }
}
