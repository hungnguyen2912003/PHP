<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordHandleRequest extends FormRequest
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
            'email' => ['required', 'email', 'exists:admins,email'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.exists' => ':attribute not found',
            'email.required' => ':attribute is required',
            'email.email' => ':attribute is not valid',
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => 'Email',
        ];
    }
}
