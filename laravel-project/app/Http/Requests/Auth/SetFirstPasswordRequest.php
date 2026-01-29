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
            'password' => 'required|string|min:6|confirmed',
            'username' => 'required|exists:users,username',
            'email' => 'required|email|exists:users,email',
        ];
    }

    public function messages(): array
    {
        return [
             'password.required' => __('messages.new_password_required'),
             'password.min' => __('messages.password_min_length'),
             'password.confirmed' => __('messages.password_confirmed_mismatch'),
        ];
    }
}
