<?php

namespace App\Http\Requests\Admin;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryHandleRequest extends FormRequest
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
        $category = Category::find($this->route('category'));
        return [
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'lang' => 'required|string|max:255',
            'is_show' => 'required|boolean|in:0,1',
            'status' => 'required|boolean|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => ':attribute is required',
            'name.string' => ':attribute must be a string',
            'name.max' => ':attribute must be less than 255 characters',
            'name.unique' => ':attribute already exists',
            'lang.required' => ':attribute is required',
            'lang.string' => ':attribute must be a string',
            'lang.max' => ':attribute must be less than 255 characters',
            'is_show.required' => ':attribute is required',
            'is_show.boolean' => ':attribute must be a boolean',
            'is_show.in' => ':attribute must be 0 or 1',
            'status.required' => ':attribute is required',
            'status.boolean' => ':attribute must be a boolean',
            'status.in' => ':attribute must be 0 or 1',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Name',
            'lang' => 'Language',
            'is_show' => 'Is Show',
            'status' => 'Status',
        ];
    }
}
