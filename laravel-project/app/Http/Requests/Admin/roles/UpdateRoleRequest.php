<?php

namespace App\Http\Requests\Admin\roles;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:roles,name,' . $this->route('id'),
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('label.name'),
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('validation.name.required'),
            'name.unique' => __('validation.name.unique'),
            'name.string' => __('validation.name.string'),
            'name.max' => __('validation.name.max'),
        ];
    }
}
