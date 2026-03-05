<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class StepLog extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'source',
        'steps',
        'measured_at',
    ];

    protected $casts = [
        'measured_at' => 'datetime',
        'source'      => 'integer',
        'steps'       => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
