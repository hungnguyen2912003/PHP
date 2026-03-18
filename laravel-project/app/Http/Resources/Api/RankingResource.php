<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RankingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'rank'               => $this->rank,
            'user_id'            => $this->user_id,
            'name'               => $this->user?->fullname ?? $this->user?->username,
            'avatar_url'         => $this->user?->avatar_url,
            'steps'              => $this->total_steps ?? 0,
            'device_source'      => $this->device_source,
            'duration'           => $this->duration ?? 0,
        ];
    }
}
