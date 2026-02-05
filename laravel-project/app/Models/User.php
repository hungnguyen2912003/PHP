<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, HasUuids, Notifiable, HasApiTokens;
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

    public function isAdmin()
    {
        return $this->role && $this->role->name === 'Admin';
    }

    public function isStaff()
    {
        return $this->role && $this->role->name === 'Staff';
    }

    public function isUser()
    {
        return $this->role && $this->role->name === 'User';
    }

    public function weights()
    {
        return $this->hasMany(Weight::class);
    }

    public function heights()
    {
        return $this->hasMany(Height::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'role' => $this->role->name,
        ];
    }
}
