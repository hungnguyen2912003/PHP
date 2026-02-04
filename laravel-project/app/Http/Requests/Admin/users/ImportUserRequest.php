<?php

namespace App\Http\Requests\Admin\users;

use Illuminate\Foundation\Http\FormRequest;

class ImportUserRequest extends FormRequest
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
            'type' => 'required|in:weight,height',
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'type.required' => __('validation.import.type.required'),
            'type.in'       => __('validation.import.type.in'),
            'file.required' => __('validation.import.file.required'),
            'file.mimes'    => __('validation.import.file.mimes'),
            'file.max'      => __('validation.import.file.max'),
        ];
    }
}
