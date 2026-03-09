<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class UserStep extends Model
{
    use HasUuids;
    protected $fillable = [
        'user_id',
        'device_source',
        'steps',
        'recorded_at',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
        'steps' => 'integer',
        'device_source' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
