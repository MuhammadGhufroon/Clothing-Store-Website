<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id', 'product_id', 'quantity', 'transaction_date', 'total_amount',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

