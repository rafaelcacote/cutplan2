<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEquipeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $equipeId = $this->route('equipe')->id ?? null;
        $tenantId = auth()->user()->tenant_id;
        
        return [
            'nome' => [
                'required',
                'string',
                'max:100',
                function ($attribute, $value, $fail) use ($tenantId, $equipeId) {
                    $exists = \App\Models\Equipe::withoutGlobalScope('tenant')
                        ->where('nome', $value)
                        ->where('tenant_id', $tenantId)
                        ->where('id', '!=', $equipeId)
                        ->exists();
                    
                    if ($exists) {
                        $fail('O nome da equipe já existe para esta empresa.');
                    }
                }
            ],
            'descricao' => 'nullable|string',
            'lider_id' => [
                'required',
                function ($attribute, $value, $fail) use ($tenantId) {
                    $exists = \App\Models\Membro::withoutGlobalScope('tenant')
                        ->where('id', $value)
                        ->where('tenant_id', $tenantId)
                        ->exists();
                    
                    if (!$exists) {
                        $fail('O líder selecionado deve pertencer à sua empresa.');
                    }
                }
            ],
            'ativo' => 'boolean',
        ];
    }
}
