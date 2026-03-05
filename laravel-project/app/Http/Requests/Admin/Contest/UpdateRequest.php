<?php

namespace App\Http\Requests\Admin\Contest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => 'required|array',
            'name.ja' => 'nullable|string|max:255',
            'name.en' => 'required|string|max:255',
            'name.zh' => 'nullable|string|max:255',
            'name.vi' => 'nullable|string|max:255',
            'type' => 'required|integer',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|array',
            'description.ja' => 'nullable|string',
            'description.en' => 'nullable|string',
            'description.zh' => 'nullable|string',
            'description.vi' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'calculate_at' => 'nullable|date|after:end_date',
            'target' => 'required|integer|min:1',
            'target_unit' => 'nullable|in:steps,km,m',
            'reward_points' => 'required|integer|min:0',
            'remove_image' => 'nullable|in:0,1',
        ];
    }

    public function attributes(): array
    {
        return [
            'name.ja' => 'Contest Name (JA)',
            'name.en' => 'Contest Name (EN)',
            'name.zh' => 'Contest Name (ZH)',
            'name.vi' => 'Contest Name (VI)',
            'type' => 'Type',
            'target' => 'Target',
            'target_unit' => 'Target Unit',
            'reward_points' => 'Reward Points',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'calculate_at' => 'Calculate At',
            'description.ja' => 'Description (JA)',
            'description.en' => 'Description (EN)',
            'description.zh' => 'Description (ZH)',
            'description.vi' => 'Description (VI)',
            'image' => 'Image',
        ];
    }
}
