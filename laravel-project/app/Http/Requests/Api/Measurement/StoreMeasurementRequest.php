<?php

namespace App\Http\Requests\Api\Measurement;

use Illuminate\Foundation\Http\FormRequest;

class StoreMeasurementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'weight' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'recorded_at' => 'nullable|date|before_or_equal:now',
            'date' => 'nullable|date_format:Y-m-d',
            'time' => 'nullable|date_format:H:i',
            'notes' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|image|max:2048',
        ];
    }
}
