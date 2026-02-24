<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Translatable\HasTranslations;

class Contest extends Model
{
    use HasUuids, HasTranslations;

    public const STATUS_INPROGRESS = 1;
    public const STATUS_COMPLETED = 2;
    public const STATUS_CANCELLED = 3;

    public $translatable = ['name', 'description'];

    protected $fillable = [
        'name',
        'type',
        'image_url',
        'description',
        'start_date',
        'end_date',
        'target',
        'reward_points',
        'win_limit',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'type' => 'integer',
        'target' => 'integer',
        'reward_points' => 'integer',
        'win_limit' => 'integer',
        'status' => 'integer',
    ];

    public function details()
    {
        return $this->hasMany(ContestDetail::class);
    }
}
