<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ContestSession extends Model
{
    use HasUuids;

    protected $fillable = [
        'contest_detail_id',
        'start_time',
        'stop_time',
        'total_steps',
        'goal_reached_at',
    ];

    protected $casts = [
        'start_time'      => 'datetime',
        'stop_time'       => 'datetime',
        'goal_reached_at' => 'datetime',
        'total_steps'     => 'integer',
    ];

    public function contestDetail()
    {
        return $this->belongsTo(ContestDetail::class);
    }
}
