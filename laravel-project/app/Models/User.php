<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'fullname',
        'username',
        'email',
        'date_of_birth',
        'gender',
        'phone',
        'password',
        'avatar_url',
        'address',
        'bio',
        'status',
        'role_id',
        'google_id',
        'activation_token',
        'activation_token_sent_at',
        'email_verified_at',
        'last_login_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'activation_token_sent_at' => 'datetime',
        'last_login_at' => 'datetime',
        'date_of_birth' => 'date',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isBanned()
    {
        return $this->status === 'banned';
    }

    public function isDeleted()
    {
        return $this->status === 'deleted';
    }

    public function weights()
    {
        return $this->hasMany(Weight::class);
    }

    public function heights()
    {
        return $this->hasMany(Height::class);
    }
}
