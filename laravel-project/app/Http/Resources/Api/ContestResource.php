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
            'description' => $this->getLocalizedField('description', $locale),
            'type' => $this->type,
            'image_url' => $this->image_url,
            'target' => $this->target,
            'reward_points' => $this->reward_points,
            'win_limit' => $this->win_limit,
            'start_date' => $this->start_date?->timestamp,
            'end_date' => $this->end_date?->timestamp,
            'status' => $this->status,
            'total_participants' => $this->total_participants ?? 0,
            'total_winners' => $this->total_winners ?? 0,
            'created_at' => $this->created_at?->timestamp,
            'updated_at' => $this->updated_at?->timestamp,
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
