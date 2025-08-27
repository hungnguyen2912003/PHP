<?php

namespace App\Http\Requests\Admin;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLanguageHandleRequest extends FormRequest
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
        $languageId = $this->route('language');
        return [
            'name' => ['required', 'string', 'max:255', 'unique:languages,name,' . $languageId],
            'lang' => ['required', 'string', 'max:255', 'unique:languages,lang,' . $languageId],
            'slug' => ['required', 'string', 'max:255', 'unique:languages,slug,' . $languageId],
            'is_default' => ['required', 'boolean'],
            'status' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => ':attribute is required',
            'name.unique' => ':attribute already exists',
            'lang.required' => ':attribute is required',
            'lang.unique' => ':attribute already exists',
            'slug.required' => ':attribute is required',
            'slug.unique' => ':attribute already exists',
            'is_default.required' => ':attribute is required',
            'status.required' => ':attribute is required',
            'is_default.boolean' => ':attribute must be a boolean',
            'status.boolean' => ':attribute must be a boolean',
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
