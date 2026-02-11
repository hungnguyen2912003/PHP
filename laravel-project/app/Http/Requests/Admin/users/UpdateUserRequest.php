<?php

namespace App\Http\Requests\Admin\users;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $id = $this->route('id');
        return [
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female',
            'date_of_birth' => 'nullable|date|before:today',
            'role' => 'required|in:admin,staff,user',
            'status' => 'required|in:active,pending,banned',
            'password' => 'nullable|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'fullname.required' => __('validation.fullname.required'),
            'email.required' => __('validation.email.required'),
            'email.email' => __('validation.email.email'),
            'email.unique' => __('validation.email.unique'),
            'phone.required' => __('validation.phone.required'),
            'address.required' => __('validation.address.required'),
            'gender.in' => __('validation.gender.in'),
            'date_of_birth.date' => __('validation.date_of_birth.date'),
            'date_of_birth.before' => __('validation.date_of_birth.before_or_equal'),
            'role.required' => __('validation.role.required'),
            'status.required' => __('validation.status.required'),
            'password.min' => __('validation.password.min'),
        ];
    }
}
