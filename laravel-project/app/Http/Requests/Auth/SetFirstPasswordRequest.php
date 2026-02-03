<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SetFirstPasswordRequest extends FormRequest
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
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|string|min:6|same:password',
            'username' => 'required|exists:users,username',
            'email' => 'required|email|exists:users,email',
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => __('validation.password.required'),
            'password.min' => __('validation.password.min', ['min' => 6]),
            'password_confirmation.required' => __('validation.password_confirmation.required'),
            'password_confirmation.same' => __('validation.password_confirmation.same'),
            'password_confirmation.min' => __('validation.password.min', ['min' => 6]),
            'username.required' => __('validation.username.required'),
            'username.exists' => __('validation.username.exists'),
            'email.required' => __('validation.email.required'),
            'email.email' => __('validation.email.email'),
            'email.exists' => __('validation.email.exists'),
        ];
    }
}
