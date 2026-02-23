<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContestDetail extends Model
{
    protected $fillable = [
        'contest_id',
        'user_id',
        'rank',
        'total_steps',
        'reward_point',
        'device_type',
        'start_at',
        'end_at',
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
