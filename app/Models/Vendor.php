<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Vendor extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'address',
    ];

    public function purchases()
    {
        return $this->hasMany(VendorPurchase::class);
    }
}
