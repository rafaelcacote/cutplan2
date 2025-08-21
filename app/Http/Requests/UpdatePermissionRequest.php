<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $permissionId = $this->route('permission')->id ?? null;
        return [
            'name' => 'required|string|max:125|unique:permissions,name,' . $permissionId,
            'guard_name' => 'nullable|string|max:125',
        ];
    }
}
