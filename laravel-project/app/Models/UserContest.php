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
        'start_time',
        'end_time',
        'total_steps',
        'rank',
        'score',
        'is_calculated',
        'completed_at',
    ];

    protected $casts = [
        'start_time'    => 'datetime',
        'end_time'      => 'datetime',
        'completed_at'  => 'datetime',
        'total_steps'   => 'integer',
        'rank'          => 'integer',
        'score'         => 'integer',
        'is_calculated' => 'boolean',
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
