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
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ];
    }

    public function messages()
    {
        return [
            'password.required' => __('messages.password_required'),
            'password.min' => __('messages.password_min'),
            'password.confirmed' => __('messages.password_confirmed'),
            'password_confirmation.required' => __('messages.password_confirmation_required'),
            'password_confirmation.min' => __('messages.password_min'),
        ];
    }
}
