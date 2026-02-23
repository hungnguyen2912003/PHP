<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    protected $fillable = [
        'name',
        'type',
        'image_url',
        'description',
        'start_date',
        'end_date',
        'status',
    ];

    public function details()
    {
        return $this->hasMany(ContestDetail::class);
    }
}
