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
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date|before:today',
        ];
    }

    public function messages()
    {
        return [
            'fullname.required' => __('validation.fullname.required'),
            'fullname.max' => __('validation.fullname.max'),
            'username.required' => __('validation.username.required'),
            'username.unique' => __('validation.username.unique'),
            'email.required' => __('validation.email.required'),
            'email.email' => __('validation.email.email'),
            'email.unique' => __('validation.email.unique'),
            'password.required' => __('validation.password.required'),
            'password.min' => __('validation.password.min'),
            'password_confirmation.required' => __('validation.password_confirmation.required'),
            'password_confirmation.same' => __('validation.password_confirmation.same'),
            'gender.required' => __('validation.gender.required'),
            'gender.in' => __('validation.gender.in'),
            'date_of_birth.required' => __('validation.date_of_birth.required'),
            'date_of_birth.date' => __('validation.date_of_birth.date'),
            'date_of_birth.before' => __('validation.date_of_birth.before'),
        ];
    }
}
