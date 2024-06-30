<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'id',
        'name',
        'password',
        'email',
        'roles',
        'logindate',
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $casts = [
        'password' => 'hashed',
        'logindate' => 'datetime',
        'email_verified_at' => 'datetime',
    ];

    protected $enumAktif = [
        'active' => 1,
        'inactive' => 0,
    ];
  

}
