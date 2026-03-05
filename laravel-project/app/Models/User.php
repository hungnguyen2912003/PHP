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

    public const STATUS_PENDING = 1;
    public const STATUS_ACTIVE = 2;
    public const STATUS_BANNED = 3;

    public const ROLE_ADMIN = 1;
    public const ROLE_STAFF = 2;
    public const ROLE_USER = 3;

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
        'role',
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


    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isStaff()
    {
        return $this->role === self::ROLE_STAFF;
    }

    public function isUser()
    {
        return $this->role === self::ROLE_USER;
    }

    public function measurements()
    {
        return $this->hasMany(Measurement::class);
    }

    public function latestMeasurement()
    {
        return $this->hasOne(Measurement::class)->latestOfMany('recorded_at');
    }

    public function stepLogs()
    {
        return $this->hasMany(StepLog::class);
    }

    public function details()
    {
        return $this->hasMany(ContestDetail::class);
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
            'role' => $this->role,
        ];
    }
}
