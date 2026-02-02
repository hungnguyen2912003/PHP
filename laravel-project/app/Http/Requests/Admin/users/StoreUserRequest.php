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
            'fullname.required' => __('messages.fullname_required'),
            'fullname.max' => __('messages.fullname_max'),
            'email.required' => __('messages.email_required'),
            'email.email' => __('messages.email_valid'),
            'email.unique' => __('messages.email_unique'),
            'role_id.required' => __('messages.role_required'),
            'role_id.exists' => __('messages.role_exists')
        ];
    }
}
