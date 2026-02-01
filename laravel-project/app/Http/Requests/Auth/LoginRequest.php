<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'login' => ['required', 'string', 'min:3', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'login.required' => __('validation.login.required'),
            'login.min' => __('validation.login.min'),
            'login.max' => __('validation.login.max'),
            'password.required' => __('validation.password.required'),
            'password.min' => __('validation.password.min'),
            'password.max' => __('validation.password.max'),
        ];
    }
}
