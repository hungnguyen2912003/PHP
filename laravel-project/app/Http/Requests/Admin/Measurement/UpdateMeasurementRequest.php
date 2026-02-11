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
            'bmi' => 'nullable|numeric|min:0',
            'body_fat' => 'nullable|numeric|min:0',
            'fat_free_body_weight' => 'nullable|numeric|min:0',
            'muscle_mass' => 'nullable|numeric|min:0',
            'skeletal_muscle_mass' => 'nullable|numeric|min:0',
            'subcutaneous_fat' => 'nullable|numeric|min:0',
            'visceral_fat' => 'nullable|numeric|min:0',
            'body_water' => 'nullable|numeric|min:0',
            'protein' => 'nullable|numeric|min:0',
            'bone_mass' => 'nullable|numeric|min:0',
            'bmr' => 'nullable|numeric|min:0',
            'waist' => 'nullable|numeric|min:0',
            'hip' => 'nullable|numeric|min:0',
            'whr' => 'nullable|numeric|min:0',
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
            'bmi.numeric' => __('validation.numeric', ['attribute' => __('label.bmi')]),
            'body_fat.numeric' => __('validation.numeric', ['attribute' => __('label.body_fat')]),
            'fat_free_body_weight.numeric' => __('validation.numeric', ['attribute' => __('label.fat_free_body_weight')]),
            'muscle_mass.numeric' => __('validation.numeric', ['attribute' => __('label.muscle_mass')]),
            'skeletal_muscle_mass.numeric' => __('validation.numeric', ['attribute' => __('label.skeletal_muscle_mass')]),
            'subcutaneous_fat.numeric' => __('validation.numeric', ['attribute' => __('label.subcutaneous_fat')]),
            'visceral_fat.numeric' => __('validation.numeric', ['attribute' => __('label.visceral_fat')]),
            'body_water.numeric' => __('validation.numeric', ['attribute' => __('label.body_water')]),
            'protein.numeric' => __('validation.numeric', ['attribute' => __('label.protein')]),
            'bone_mass.numeric' => __('validation.numeric', ['attribute' => __('label.bone_mass')]),
            'bmr.numeric' => __('validation.numeric', ['attribute' => __('label.bmr')]),
            'waist.numeric' => __('validation.numeric', ['attribute' => __('label.waist')]),
            'hip.numeric' => __('validation.numeric', ['attribute' => __('label.hip')]),
            'whr.numeric' => __('validation.numeric', ['attribute' => __('label.whr')]),
        ];
    }
}
