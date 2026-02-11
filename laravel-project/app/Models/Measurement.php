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
        'bmi',
        'body_fat',
        'fat_free_body_weight',
        'muscle_mass',
        'skeletal_muscle_mass',
        'subcutaneous_fat',
        'visceral_fat',
        'body_water',
        'protein',
        'bone_mass',
        'bmr',
        'waist',
        'hip',
        'whr',
        'recorded_at',
        'attachment_url',
        'notes',
    ];

    protected $casts = [
        'recorded_at' => 'datetime:Y-m-d H:i:s',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'height' => 'decimal:2',
        'weight' => 'decimal:2',
        'bmi' => 'decimal:2',
        'body_fat' => 'decimal:2',
        'fat_free_body_weight' => 'decimal:2',
        'muscle_mass' => 'decimal:2',
        'skeletal_muscle_mass' => 'decimal:2',
        'subcutaneous_fat' => 'decimal:2',
        'visceral_fat' => 'decimal:2',
        'body_water' => 'decimal:2',
        'protein' => 'decimal:2',
        'bone_mass' => 'decimal:2',
        'bmr' => 'decimal:2',
        'waist' => 'decimal:2',
        'hip' => 'decimal:2',
        'whr' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
