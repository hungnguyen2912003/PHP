<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordHandleRequest extends FormRequest
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
            'new_password' => ['required', 'min:8'],
            'confirm_password' => ['required', 'same:new_password'],
            'current_password' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'new_password.required' => ':attribute is required',
            'new_password.min' => ':attribute must be at least 8 characters',
            'confirm_password.required' => ':attribute is required',
            'confirm_password.same' => ':attribute must be same as new password',
            'current_password.required' => ':attribute is required',
        ];
    }

    public function attributes(): array
    {
        return [
            'new_password' => 'New password',
            'confirm_password' => 'Confirm password',
            'current_password' => 'Current password',
        ];
    }
}
