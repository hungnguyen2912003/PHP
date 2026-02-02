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
            'fullname.required' => __('validations/setting.fullname.required'),
            'fullname.string' => __('validations/setting.fullname.string'),
            'fullname.max' => __('validations/setting.fullname.max'),

            'date_of_birth.date' => __('validations/setting.date_of_birth.date'),
            'date_of_birth.before_or_equal' => __('validations/setting.date_of_birth.before_or_equal'),

            'gender.in' => __('validations/setting.gender.in'),

            'phone.regex' => __('validations/setting.phone.regex'),
            'phone.unique' => __('validations/setting.phone.unique'),

            'address.string' => __('validations/setting.address.string'),
            'address.max' => __('validations/setting.address.max'),

            'bio.string'=> __('validations/setting.bio.string'),
            'bio.max' => __('validations/setting.bio.max'),
        ];
    }
}