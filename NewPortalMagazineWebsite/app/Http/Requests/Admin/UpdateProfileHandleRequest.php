<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileHandleRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:admins,email,' . $this->id],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => ':attribute is required',
            'name.string' => ':attribute must be a string',
            'name.max' => ':attribute must be less than 255 characters',
            'email.required' => ':attribute is required',
            'email.email' => ':attribute must be a valid email address',
            'email.max' => ':attribute must be less than 255 characters',
            'email.unique' => ':attribute already exists',
            'image.image' => ':attribute must be an image',
            'image.mimes' => ':attribute must be a file of type: jpeg, png, jpg, gif, svg',
            'image.max' => ':attribute must be less than 2048 kilobytes',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Name',
            'email' => 'Email',
            'image' => 'Image',
        ];
    }
}
