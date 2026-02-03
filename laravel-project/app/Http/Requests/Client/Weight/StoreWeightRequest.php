<?php

namespace App\Http\Requests\Client\Weight;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreWeightRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guard("web")->check();
    }

    public function rules(): array
    {
        return [
            'weight' => 'required|numeric|min:0',
            'recorded_at' => 'required|date|before_or_equal:now',
            'notes' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'weight.required' => __('validation.weight.required'),
            'weight.numeric' => __('validation.weight.numeric'),
            'weight.min' => __('validation.weight.min'),
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
