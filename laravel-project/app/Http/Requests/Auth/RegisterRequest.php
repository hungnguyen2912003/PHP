<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'fullname.required' => __('messages.fullname_required'),
            'fullname.max' => __('messages.fullname_max'),
            'username.required' => __('messages.username_required'),
            'username.unique' => __('messages.username_unique'),
            'email.required' => __('messages.email_required'),
            'email.email' => __('messages.email_valid'),
            'email.unique' => __('messages.email_unique'),
            'password.required' => __('messages.password_required'),
            'password.min' => __('messages.password_min'),
            'password_confirmation.required' => __('messages.password_confirmation_required'),
            'password_confirmation.same' => __('messages.password_confirmed'),
        ];
    }
}
