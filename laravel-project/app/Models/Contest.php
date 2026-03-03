<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Translatable\HasTranslations;

class Contest extends Model
{
    use HasUuids, HasTranslations;

    public const STATUS_INPROGRESS = 1;
    public const STATUS_COMPLETED = 2;
    public const STATUS_CANCELLED = 3;

    public $translatable = ['name', 'description'];

    protected $fillable = [
        'name',
        'type',
        'image_url',
        'description',
        'start_date',
        'end_date',
        'target',
        'reward_points',
        'win_limit',
        'calculate_at',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'calculate_at' => 'datetime',
        'type' => 'integer',
        'target' => 'integer',
        'reward_points' => 'integer',
        'win_limit' => 'integer',
        'status' => 'integer',
    ];

    public function details()
    {
        return $this->hasMany(ContestDetail::class);
    }

    /**
     * Get the ranked winners query (participants who completed the target, sorted by fastest).
     */
    public function getRankedWinners()
    {
        return ContestDetail::with('user')
            ->where('contest_id', $this->id)
            ->where('total_steps', '>=', $this->target)
            ->orderByRaw('TIMESTAMPDIFF(SECOND, start_at, end_at) ASC')
            ->orderBy('start_at', 'asc')
            ->limit($this->win_limit);
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
