<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Contest extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'type',
        'image_url',
        'description',
        'start_date',
        'end_date',
        'target',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'type' => 'integer',
        'target' => 'integer',
    ];

    public function details()
    {
        return $this->hasMany(ContestDetail::class);
    }
}
