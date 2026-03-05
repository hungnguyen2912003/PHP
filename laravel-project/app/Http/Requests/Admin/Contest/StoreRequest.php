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
            'name.vi' => 'nullable|string|max:255',
            'type' => 'required|integer',
            'image_url' => 'nullable|string',
            'description' => 'nullable|array',
            'description.ja' => 'nullable|string',
            'description.en' => 'nullable|string',
            'description.zh' => 'nullable|string',
            'description.vi' => 'nullable|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'calculate_at' => 'nullable|date|after:end_date',
            'target' => 'required|integer|min:1',
            'reward_points' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function attributes(): array
    {
        return [
            'name.ja' => __('label.contest_name') . ' (' . __('label.lang_ja') . ')',
            'name.en' => __('label.contest_name') . ' (' . __('label.lang_en') . ')',
            'name.zh' => __('label.contest_name') . ' (' . __('label.lang_zh') . ')',
            'name.vi' => __('label.contest_name') . ' (' . __('label.lang_vi') . ')',
            'type' => __('label.type'),
            'target' => __('label.target'),
            'reward_points' => __('label.reward_points'),
            'start_date' => __('label.start_date'),
            'end_date' => __('label.end_date'),
            'calculate_at' => __('label.calculate_at'),
            'description.ja' => __('label.description') . ' (' . __('label.lang_ja') . ')',
            'description.en' => __('label.description') . ' (' . __('label.lang_en') . ')',
            'description.zh' => __('label.description') . ' (' . __('label.lang_zh') . ')',
            'description.vi' => __('label.description') . ' (' . __('label.lang_vi') . ')',
            'image' => __('label.image'),
        ];
    }
}
