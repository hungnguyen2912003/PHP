<?php

namespace App\Http\Requests\Api\Contest;

use Illuminate\Foundation\Http\FormRequest;

class ImportStepsRequest extends FormRequest
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
            'total_steps' => ['required', 'integer', 'min:0'],
            'device_type' => ['nullable', 'integer'],
            'start_at' => ['required', 'date_format:Y-m-d H:i'],
            'end_at' => ['required', 'date_format:Y-m-d H:i', 'after_or_equal:start_at'],
        ];
    }
}
