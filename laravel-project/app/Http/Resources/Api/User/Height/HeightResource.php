<?php

namespace App\Http\Resources\Api\User\Height;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HeightResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'height' => $this->height,
            'recorded_at' => $this->recorded_at,
            'attachment_url' => $this->attachment_url,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
