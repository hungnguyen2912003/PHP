<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordHandleRequest extends FormRequest
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
            'password' => ['required', 'min:8'],
            'password_confirmation' => ['required', 'same:password'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.exists' => ':attribute not found',
            'email.required' => ':attribute is required',
            'email.email' => ':attribute is not valid',
            'password.required' => ':attribute is required',
            'password.min' => ':attribute must be at least 8 characters',
            'password_confirmation.required' => ':attribute is required',
            'password_confirmation.same' => ':attribute must be same as password',
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => 'Email',
            'password' => 'Password',
            'password_confirmation' => 'Confirm password',
        ];
    }
}
