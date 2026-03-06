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

        $data = [
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
        ];

        // Detail fields (only present in show)
        if ($this->resource->getAttribute('is_joined') !== null) {
            $data['total_completed'] = $this->total_completed ?? 0;
            $data['my_progress'] = [
                'is_joined' => $this->resource->getAttribute('is_joined'),
                'total_steps' => $this->resource->getAttribute('user_total_steps'),
                'step_progress' => $this->resource->getAttribute('step_progress'),
                'joined_at' => $this->resource->getAttribute('user_joined_at')?->timestamp,
                'completed_at' => $this->resource->getAttribute('user_completed_at')?->timestamp,
            ];
        }

        return $data;
    }
}
