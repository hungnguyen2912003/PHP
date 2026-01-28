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
            'old_password.required' => __('messages.old_password_required'),
            'password.required' => __('messages.new_password_required'),
            'password.min' => __('messages.password_min_length'),
            'password.confirmed' => __('messages.password_confirmed_mismatch'),
        ];
    }
}
