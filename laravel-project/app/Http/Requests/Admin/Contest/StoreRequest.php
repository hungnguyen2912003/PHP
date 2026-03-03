<?php

namespace App\Http\Requests\Admin\Contest;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name.vn' => 'nullable|string|max:255',
            'type' => 'required|integer',
            'image_url' => 'nullable|string',
            'description' => 'nullable|array',
            'description.ja' => 'nullable|string',
            'description.en' => 'nullable|string',
            'description.zh' => 'nullable|string',
            'description.vn' => 'nullable|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'calculate_at' => 'nullable|date|after:end_date',
            'target' => 'required|integer|min:1',
            'reward_points' => 'required|integer|min:1',
            'win_limit' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function attributes(): array
    {
        return [
            'name.ja' => 'Contest Name (JA)',
            'name.en' => 'Contest Name (EN)',
            'name.zh' => 'Contest Name (ZH)',
            'name.vn' => 'Contest Name (VN)',
            'type' => 'Type',
            'target' => 'Target',
            'reward_points' => 'Reward Points',
            'win_limit' => 'Win Limit',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'calculate_at' => 'Calculate At',
            'description.ja' => 'Description (JA)',
            'description.en' => 'Description (EN)',
            'description.zh' => 'Description (ZH)',
            'description.vn' => 'Description (VN)',
            'image' => 'Image',
        ];
    }
}
