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
            'weight' => 'required|numeric|min:0',
            'height' => 'required|numeric|min:0',
            'recorded_at' => 'required|date|before_or_equal:now',
            'notes' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|image|max:2048',
        ];
    }
}
