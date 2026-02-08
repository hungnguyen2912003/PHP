<?php

namespace App\Http\Requests\Admin\Measurement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateMeasurementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'weight' => 'sometimes|numeric|min:0',
            'height' => 'sometimes|numeric|min:0',
            'recorded_at' => 'required|date|before_or_equal:now',
            'notes' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|image|max:2048',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'weight.numeric' => __('validation.weight.numeric'),
            'weight.min' => __('validation.weight.min'),
            'height.numeric' => __('validation.height.numeric'),
            'height.min' => __('validation.height.min'),
            'recorded_at.required' => __('validation.recorded_at.required'),
            'recorded_at.date' => __('validation.recorded_at.date'),
            'recorded_at.before_or_equal' => __('validation.recorded_at.before_or_equal'),
            'attachment.file' => __('validation.attachment.file'),
            'attachment.image' => __('validation.attachment.image'),
            'attachment.max' => __('validation.attachment.max'),
            'notes.string' => __('validation.notes.string'),
            'notes.max' => __('validation.notes.max'),
        ];
    }
}
