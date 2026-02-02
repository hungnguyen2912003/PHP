<?php

namespace App\Http\Requests\Common;

use Illuminate\Foundation\Http\FormRequest;

class AvatarUploadRequest extends FormRequest
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
            'avatar_url_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'avatar_url_file.required' => __('validations/profile.avatar_url_file.required'),
            'avatar_url_file.image' => __('validations/profile.avatar_url_file.image'),
            'avatar_url_file.mimes' => __('validations/profile.avatar_url_file.mimes'),
            'avatar_url_file.max' => __('validations/profile.avatar_url_file.max'),
        ];
    }
}
