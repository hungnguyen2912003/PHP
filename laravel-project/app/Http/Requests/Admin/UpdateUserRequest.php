<?php

namespace App\Http\Requests\Admin;

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
            'fullname.required' => __('messages.fullname_required'),
            'email.required' => __('messages.email_required'),
            'email.email' => __('messages.email_valid'),
            'email.unique' => __('messages.email_unique'),
            'phone.required' => __('messages.phone_required'),
            'address.required' => __('messages.address_required'),
            'gender.required' => __('messages.gender_required'),
            'date_of_birth.required' => __('messages.date_of_birth_required'),
            'role_id.required' => __('messages.role_required'),
            'status.required' => __('messages.status_required'),
            'password.required' => __('messages.password_required'),
            'password.min' => __('messages.password_min_length'),
        ];
    }
}
