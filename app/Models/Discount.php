<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'category_discount_id',
        'product_id',
        'start_date',
        'end_date',
        'percentage',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function categoryDiscount()
    {
        return $this->belongsTo(DiscountCategory::class, 'category_discount_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
