<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $roleId = $this->route('role')->id ?? null;
        return [
            'name' => 'required|string|max:125|unique:roles,name,' . $roleId,
            'guard_name' => 'nullable|string|max:125',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ];
    }
}
