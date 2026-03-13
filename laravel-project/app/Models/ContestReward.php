<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ContestReward extends Model
{
    use HasUuids;
    protected $fillable = [
        'contest_id',
        'rank',
        'reward_percent',
    ];

    public function contest()
    {
        return $this->belongsTo(Contest::class);
    }
}
