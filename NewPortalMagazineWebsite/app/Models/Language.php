<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Language extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'languages';
    protected $fillable = ['name', 'slug', 'is_default', 'status'];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', 1);
    }
}
