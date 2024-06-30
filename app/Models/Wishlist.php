<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Discount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'product_id',
    ];

    protected $primaryKey = 'id'; 

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id'); 
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id'); 
    }

    public function discounts()
    {
        return $this->hasManyThrough(Discount::class, Product::class, 'id', 'product_id');
    }
}