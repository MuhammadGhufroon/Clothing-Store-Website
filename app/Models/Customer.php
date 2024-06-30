<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;


class Customer extends Authenticatable
{
    use Notifiable;

    protected $table = 'customers';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address1',
        'address2',
        'address3',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $casts = [
        'password' => 'hashed',
        'logindate' => 'datetime',
        'email_verified_at' => 'datetime',
    ];

    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            return asset('storage/' . $this->profile_picture);
        }
    }
}
