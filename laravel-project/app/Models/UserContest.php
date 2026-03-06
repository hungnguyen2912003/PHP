<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserContest extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'contest_id',
        'joined_at',
        'latest_start_time',
        'latest_end_time',
        'total_steps',
        'final_rank',
        'final_score',
        'is_calculated',
        'completed_at',
    ];

    protected $casts = [
        'joined_at'         => 'datetime',
        'latest_start_time' => 'datetime',
        'latest_end_time'   => 'datetime',
        'completed_at'      => 'datetime',
        'total_steps'       => 'integer',
        'final_rank'        => 'integer',
        'final_score'       => 'integer',
        'is_calculated'     => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contest(): BelongsTo
    {
        return $this->belongsTo(Contest::class);
    }
}
