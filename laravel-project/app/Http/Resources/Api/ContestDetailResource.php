<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContestDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $locale = $request->header('Accept-Language', $request->query('lang', 'en'));

        $contest = $this->resource;
        $userDetail = $contest->user_detail;

        return [
            'id' => $contest->id,
            'name' => $this->getLocalizedField('name', $locale),
            'description' => $this->getLocalizedField('description', $locale),
            'image_url' => $contest->image_url,
            'status' => $contest->status,
            'start_date' => $contest->start_date?->timestamp,
            'end_date' => $contest->end_date?->timestamp,
            'target' => $contest->target,
            'reward_points' => $contest->reward_points,
            'win_limit' => $contest->win_limit,
            'total_participants' => $contest->total_participants ?? 0,
            'total_winners' => min($contest->total_winners ?? 0, $contest->win_limit),

            // User participation
            'is_joined' => !is_null($userDetail),
            'user_detail' => $userDetail ? [
                'total_steps' => $userDetail->total_steps ?? 0,
                'progress' => $contest->target > 0
                    ? min(round(($userDetail->total_steps ?? 0) / $contest->target * 100), 100)
                    : 0,
                'device_type' => $userDetail->device_type,
                'start_at' => $userDetail->start_at?->timestamp,
                'end_at' => $userDetail->end_at?->timestamp,
                'status' => $userDetail->status,
            ] : null,
        ];
    }

    /**
     * Get a translatable field value for the given locale, falling back to 'en'.
     */
    private function getLocalizedField(string $field, string $locale): ?string
    {
        $value = $this->getTranslation($field, $locale, false);

        if (empty($value)) {
            $value = $this->getTranslation($field, 'en', false);
        }

        return $value ?: null;
    }
}
