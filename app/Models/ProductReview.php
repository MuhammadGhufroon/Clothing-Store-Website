<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'product_id',
        'rating',
        'comment',
    ];

    public function customer()
    {
        // Menghubungkan ulasan produk dengan pelanggan yang memberikannya
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function product()
    {
        // Menghubungkan ulasan produk dengan produk yang direview
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
