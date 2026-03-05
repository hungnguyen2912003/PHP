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
            'name' => $contest->getLocalizedField('name', $locale),
            'description' => $contest->getLocalizedField('desc', $locale),
            'image_url' => $contest->image_url,
            'status' => $contest->status,
            'start_date' => $contest->start_date?->timestamp,
            'end_date' => $contest->end_date?->timestamp,
            'target' => $contest->target,
            'reward_points' => $contest->reward_points,
            'total_participants' => $contest->total_participants ?? 0,
            'total_winners' => $contest->total_winners ?? 0,

            // User participation
            'user_detail' => $userDetail ? [
                'final_steps' => $userDetail->final_steps ?? 0,
                'progress' => $contest->target > 0
                    ? min(round(($userDetail->final_steps ?? 0) / $contest->target * 100), 100)
                    : 0,
                'joined_at' => $userDetail->joined_at?->timestamp,
                'status' => $userDetail->status,
            ] : null,
        ];
    }
}
