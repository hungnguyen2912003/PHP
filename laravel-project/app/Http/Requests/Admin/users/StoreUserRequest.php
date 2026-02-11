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
            'role' => 'required|in:admin,staff'
        ];
    }

    public function messages(): array
    {
        return [
            'fullname.required' => __('validation.fullname.required'),
            'fullname.max' => __('validation.fullname.max'),
            'email.required' => __('validation.email.required'),
            'email.email' => __('validation.email.email'),
            'email.unique' => __('validation.email.unique'),
            'role.required' => __('validation.role.required'),
            'role.in' => __('validation.role.in')
        ];
    }
}
