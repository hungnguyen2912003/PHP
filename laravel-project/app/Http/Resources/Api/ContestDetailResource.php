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
            'id' => $this->id,
            'name' => $this->getLocalizedField('name', $locale),
            'description' => $this->getLocalizedField('desc', $locale),
            'type' => $this->type,
            'image_url' => $this->image_url,
            'target' => $this->target,
            'reward_points' => $this->reward_points,
            'start_date' => $this->start_date?->timestamp,
            'end_date' => $this->end_date?->timestamp,
            'total_participants' => $this->total_participants ?? 0,
            'status' => $this->status,
            'is_joined' => $userDetail !== null,
            'user_progress' => $userDetail ? [
                'final_steps' => $userDetail->final_steps ?? 0,
                'progress' => $this->target > 0
                    ? min(round(($userDetail->final_steps ?? 0) / $this->target * 100), 100)
                    : 0,
                'joined_at' => $userDetail->joined_at?->timestamp,
                'status' => $userDetail->status,
            ] : null,
        ];
    }
}
