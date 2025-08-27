<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateLanguageHandleRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:languages,name'],
            'lang' => ['required', 'string', 'max:255', 'unique:languages,lang'],
            'slug' => ['required', 'string', 'max:255', 'unique:languages,slug'],
            'is_default' => ['required', 'boolean'],
            'status' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => ':attribute is required',
            'lang.required' => ':attribute is required',
            'slug.required' => ':attribute is required',
            'is_default.required' => ':attribute is required',
            'status.required' => ':attribute is required',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Name',
            'lang' => 'Language',
            'slug' => 'Slug',
            'is_default' => 'Is default',
            'status' => 'Status',
        ];
    }
}
