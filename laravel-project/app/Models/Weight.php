<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Weight extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'weight',
        'recorded_at',
        'attachment_url',
        'notes',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
        'weight' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
