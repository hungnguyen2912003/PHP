<?php

namespace App\Http\Requests\Api\Measurement;

use Illuminate\Foundation\Http\FormRequest;

class StoreWeightRequest extends FormRequest
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
            'weight' => 'required|numeric|min:0',
            'time' => 'required|date_format:H:i',
            'attachment' => 'nullable|file|image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'weight.required' => __('validation.weight.required'),
            'weight.numeric' => __('validation.weight.numeric'),
            'weight.min' => __('validation.weight.min'),
            'time.required' => __('validation.time.required'),
            'time.date_format' => __('validation.time.date_format'),
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'date' => $this->route('date'),
        ]);
    }
}
