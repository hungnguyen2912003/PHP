<?php

namespace App\Http\Requests\Admin\settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guard("admin")->check();
    }

    public function rules(): array
    {
        $user = Auth::guard("admin")->user();
        return [
            'fullname' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date|before_or_equal:today',
            'gender' => 'nullable|in:male,female,other',
            'phone' => [
                'nullable',
                'regex:/^(03|05|07|08|09)[0-9]{8}$/',
                Rule::unique('admins', 'phone')->ignore($user->id),
            ],
            'address' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'fullname.required' => __('validation.fullname.required'),
            'fullname.string' => __('validation.fullname.string'),
            'fullname.max' => __('validation.fullname.max'),

            'date_of_birth.date' => __('validation.date_of_birth.date'),
            'date_of_birth.before_or_equal' => __('validation.date_of_birth.before_or_equal'),

            'gender.in' => __('validation.gender.in'),

            'phone.regex' => __('validation.phone.regex'),
            'phone.unique' => __('validation.phone.unique'),

            'address.string' => __('validation.address.string'),
            'address.max' => __('validation.address.max'),

            'bio.string'=> __('validation.bio.string'),
            'bio.max' => __('validation.bio.max'),
        ];
    }
}