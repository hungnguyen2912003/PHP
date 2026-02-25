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
        'total_steps',
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
