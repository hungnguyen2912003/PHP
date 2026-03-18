<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserContest extends Model
{
    use HasUuids;

    public const STATUS_INPROGRESS = 0;
    public const STATUS_COMPLETED = 1;

    protected $fillable = [
        'user_id',
        'contest_id',
        'start_time',
        'end_time',
        'duration',
        'total_steps',
        'rank',
        'score',
        'is_calculated',
        'status',
        'device_source',
    ];

    protected $casts = [
        'start_time'    => 'datetime',
        'end_time'      => 'datetime',
        'duration'      => 'integer',
        'total_steps'   => 'integer',
        'rank'          => 'integer',
        'score'         => 'integer',
        'is_calculated' => 'boolean',
        'status'        => 'integer',
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
