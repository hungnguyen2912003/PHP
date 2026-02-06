<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Measurement extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'weight',
        'height',
        'recorded_at',
        'attachment_url',
        'notes',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
        'height' => 'decimal:2',
        'weight' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
