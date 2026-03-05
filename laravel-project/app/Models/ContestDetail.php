<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ContestDetail extends Model
{
    use HasUuids;
    public const STATUS_INCOMPLETED = 1;
    public const STATUS_COMPLETED = 2;
    public const STATUS_CANCELLED = 3;

    protected $fillable = [
        'contest_id',
        'user_id',
        'joined_at',
        'final_steps',
        'final_rank',
        'reward_points',
        'status',
    ];

    protected $casts = [
        'joined_at'     => 'datetime',
        'final_steps'   => 'integer',
        'final_rank'    => 'integer',
        'reward_points' => 'integer',
        'status'        => 'integer',
    ];

    public function contest()
    {
        return $this->belongsTo(Contest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sessions()
    {
        return $this->hasMany(ContestSession::class);
    }

    public function latestSession()
    {
        return $this->hasOne(ContestSession::class)->latestOfMany();
    }
}