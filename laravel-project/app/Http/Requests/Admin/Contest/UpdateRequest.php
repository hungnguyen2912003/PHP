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
            'name.ja' => 'required|string|max:255',
            'name.en' => 'required|string|max:255',
            'name.zh' => 'required|string|max:255',
            'type' => 'required|integer',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|array',
            'description.ja' => 'nullable|string',
            'description.en' => 'nullable|string',
            'description.zh' => 'nullable|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'target' => 'required|integer|min:1',
            'reward_points' => 'required|integer|min:0',
            'win_limit' => 'required|integer|min:0',
            'status' => 'required|in:inprogress,completed,cancelled',
            'remove_image' => 'nullable|in:0,1',
        ];
    }
}
