<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Admin extends Model
{
    use HasFactory, Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'name',
        'image',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
