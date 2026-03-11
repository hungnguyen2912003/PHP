<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Contest extends Model
{
    use HasUuids;

    public const STATUS_INPROGRESS = 1;
    public const STATUS_COMPLETED = 2;
    public const STATUS_FINALIZED = 3;

    protected $fillable = [
        'name_ja',
        'name_en',
        'name_vi',
        'name_zh',
        'desc_ja',
        'desc_en',
        'desc_vi',
        'desc_zh',
        'type',
        'image_url',
        'start_date',
        'end_date',
        'target',
        'reward_points',
        'calculate_at',
        'status',
    ];

    protected $casts = [
        'start_date'    => 'datetime',
        'end_date'      => 'datetime',
        'calculate_at'  => 'datetime',
        'type'          => 'integer',
        'target'        => 'integer',
        'reward_points' => 'integer',
        'status'        => 'integer',
    ];

    /**
     * Accessor: get localized name based on current locale.
     */
    public function getNameAttribute(): ?string
    {
        return $this->getLocalizedField('name');
    }

    /**
     * Accessor: get localized description based on current locale.
     */
    public function getDescriptionAttribute(): ?string
    {
        return $this->getLocalizedField('desc');
    }

    /**
     * Get value for a field based on current locale with fallback to 'en'.
     */
    public function getLocalizedField(string $prefix, ?string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();

        $value = $this->attributes["{$prefix}_{$locale}"] ?? null;

        // Fallback to English
        if (empty($value) && $locale !== 'en') {
            $value = $this->attributes["{$prefix}_en"] ?? null;
        }

        return $value;
    }

    public function participants()
    {
        return $this->hasMany(UserContest::class);
    }

    /**
     * Get the ranked winners query (participants who completed the target, sorted by fastest).
     */
    public function getRankedWinners()
    {
        return UserContest::with('user')
            ->where('contest_id', $this->id)
            ->where('total_steps', '>=', $this->target)
            ->orderBy('end_time', 'asc')
            ->orderByRaw('TIMESTAMPDIFF(SECOND, start_time, end_time) ASC')
            ->orderBy('start_time', 'asc');
    }

    /**
     * Calculate reward points based on rank position.
     * Top 1: 100%, Top 2: 80%, Top 3: 70%, Top 4+: 60%
     */
    public function calculateReward(int $rank): int
    {
        return match (true) {
            $rank === 1 => $this->reward_points,
            $rank === 2 => (int) round($this->reward_points * 0.8),
            $rank === 3 => (int) round($this->reward_points * 0.7),
            default => (int) round($this->reward_points * 0.6),
        };
    }

    /**
     * Format duration between two datetime values as HH:MM:SS.
     */
    public static function formatDuration($startAt, $endAt): string
    {
        if (!$startAt || !$endAt) return '-';
        $seconds = abs($startAt->diffInSeconds($endAt));
        $h = intdiv($seconds, 3600);
        $m = intdiv($seconds % 3600, 60);
        $s = $seconds % 60;
        return sprintf('%02d:%02d:%02d', $h, $m, $s);
    }
}
