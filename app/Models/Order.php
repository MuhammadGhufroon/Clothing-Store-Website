<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
   
    protected $fillable = [
        'customer_id', 'quantity', 'order_date', 'total_amount', 'status',
    ];

  
    protected $casts = [
        'order_date' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderDetails()
{
    return $this->hasMany(OrderDetail::class);
}

public function delivery()
{
    return $this->hasOne(Delivery::class);
}


}
