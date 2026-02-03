<?php

namespace App\Http\Requests\Admin\settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChangePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guard("admin")->check();
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:6'],
            'new_password_confirmation' => ['required', 'string', 'same:new_password'],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => __('validation.current_password.required'),
            'new_password.required' => __('validation.new_password.required'),
            'new_password.min' => __('validation.new_password.min'),
            'new_password_confirmation.required' => __('validation.new_password_confirmation.required'),
            'new_password_confirmation.same' => __('validation.new_password_confirmation.same'),
        ];
    }
}
