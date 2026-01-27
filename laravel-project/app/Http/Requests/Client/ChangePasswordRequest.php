<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'old_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'old_password.required' => 'The old password is required.',
            'password.required' => 'The new password is required.',
            'password.min' => 'The new password must be at least 6 characters.',
            'password.confirmed' => 'The new password confirmation does not match.',
        ];
    }
}
