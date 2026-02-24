<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContestDetail extends Model
{
    public const STATUS_INCOMPLETED = 1;
    public const STATUS_COMPLETED = 2;
    public const STATUS_CANCELLED = 3;

    protected $fillable = [
        'contest_id',
        'user_id',
        'rank',
        'total_steps',
        'reward_point',
        'device_type',
        'start_at',
        'end_at',
        'status',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'status' => 'integer',
    ];

    public function contest()
    {
        return $this->belongsTo(Contest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
