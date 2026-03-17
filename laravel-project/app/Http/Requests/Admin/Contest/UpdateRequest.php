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
            'reward_points' => 'required|integer|min:0',
            'consolation_points' => 'required|integer|min:0',
            'remove_image' => 'nullable|in:0,1',
            'rewards' => 'required|array|min:1',
            'rewards.*.rank' => 'required|integer|min:1',
            'rewards.*.reward_percent' => 'required|numeric|min:0|max:100',
        ];
    }

    /**
     * Custom validation: reward percentages must be in descending order.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $rewards = $this->input('rewards');
            if (empty($rewards) || count($rewards) < 2) {
                return;
            }

            // Check that higher rank (lower number) has higher or equal percentage
            $sorted = collect($rewards)
                ->filter(fn($r) => !empty($r['rank']) && isset($r['reward_percent']))
                ->sortBy('rank')
                ->values();

            for ($i = 0; $i < $sorted->count() - 1; $i++) {
                $current = $sorted->get($i);
                $next = $sorted->get($i + 1);
                if ($current['reward_percent'] < $next['reward_percent']) {
                    $validator->errors()->add(
                        'rewards',
                        __('validation.rewards_percent_order', [
                            'rank1' => $current['rank'],
                            'rank2' => $next['rank'],
                        ])
                    );
                    break;
                }
            }
        });
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
            'consolation_points' => __('label.consolation_points'),
            'start_date' => __('label.start_date'),
            'end_date' => __('label.end_date'),
            'calculate_at' => __('label.calculate_at'),
            'description.ja' => __('label.description') . ' (' . __('label.lang_ja') . ')',
            'description.en' => __('label.description') . ' (' . __('label.lang_en') . ')',
            'description.zh' => __('label.description') . ' (' . __('label.lang_zh') . ')',
            'description.vi' => __('label.description') . ' (' . __('label.lang_vi') . ')',
            'image' => __('label.image'),
            'rewards.*.rank' => __('label.rank'),
            'rewards.*.reward_percent' => __('label.reward_percent'),
        ];
    }
}
