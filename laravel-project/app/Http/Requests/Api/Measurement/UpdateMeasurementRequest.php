<?php

namespace App\Http\Requests\Api\Measurement;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMeasurementRequest extends FormRequest
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
            'weight' => 'sometimes|numeric|min:0',
            'height' => 'sometimes|numeric|min:0',
            'recorded_at' => 'sometimes|date|before_or_equal:now',
            'notes' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|image|max:2048',
        ];
    }
}
