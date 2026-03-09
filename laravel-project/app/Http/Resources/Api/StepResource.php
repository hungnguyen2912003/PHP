<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class StepResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'device_source' => $this->device_source,
            'steps' => $this->steps,
            'recorded_at' => $this->recorded_at,
        ];
    }
}
