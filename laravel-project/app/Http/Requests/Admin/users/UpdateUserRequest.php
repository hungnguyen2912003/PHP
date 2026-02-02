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
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:active,pending,banned',
            'password' => 'nullable|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'fullname.required' => __('validations/users.fullname.required'),
            'email.required' => __('validations/users.email.required'),
            'email.email' => __('validations/users.email.email'),
            'email.unique' => __('validations/users.email.unique'),
            'phone.required' => __('validations/users.phone.required'),
            'address.required' => __('validations/users.address.required'),
            'gender.required' => __('validations/users.gender.required'),
            'date_of_birth.required' => __('validations/users.date_of_birth.required'),
            'role_id.required' => __('validations/users.role_id.required'),
            'status.required' => __('validations/users.status.required'),
            'password.required' => __('validations/users.password.required'),
            'password.min' => __('validations/users.password.min'),
        ];
    }
}
