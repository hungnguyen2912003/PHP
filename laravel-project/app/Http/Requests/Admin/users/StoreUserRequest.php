<?php

namespace App\Http\Requests\Admin\users;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'role_id' => 'required|exists:roles,id'
        ];
    }

    public function messages(): array
    {
        return [
            'fullname.required' => __('validations/users.fullname.required'),
            'fullname.max' => __('validations/users.fullname.max'),
            'email.required' => __('validations/users.email.required'),
            'email.email' => __('validations/users.email.email'),
            'email.unique' => __('validations/users.email.unique'),
            'role_id.required' => __('validations/users.role_id.required'),
            'role_id.exists' => __('validations/users.role_id.exists')
        ];
    }
}
