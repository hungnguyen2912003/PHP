<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * Name/description are returned in the requested locale with fallback to 'en'.
     */
    public function toArray(Request $request): array
    {
        $locale = $request->header('Accept-Language', $request->query('lang', 'en'));

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
            'total_completed' => $this->total_completed ?? 0,
            'status' => $this->status,
            'user_contest' => $this->whenLoaded('user_contest', function () {
                return [
                    'id' => $this->user_contest->id,
                    'start_time' => $this->user_contest->start_time?->timestamp,
                    'end_time' => $this->user_contest->end_time?->timestamp,
                    'total_steps' => $this->user_contest->total_steps,
                    'is_calculated' => $this->user_contest->is_calculated,
                    'completed_at' => $this->user_contest->completed_at?->timestamp
                ];
            }),
        ];
    }
}
