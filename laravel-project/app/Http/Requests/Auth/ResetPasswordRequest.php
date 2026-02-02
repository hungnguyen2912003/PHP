<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => __('validations/auth.email.required'),
            'email.email' => __('validations/auth.email.valid'),
            'password.required' => __('validations/auth.password.required'),
            'password.min' => __('validations/auth.password.min'),
            'password_confirmation.required' => __('validations/auth.password_confirmation.required'),
            'password_confirmation.same' => __('validations/auth.password_confirmation.same'),
        ];
    }
}
