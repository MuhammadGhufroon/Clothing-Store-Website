<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer; // Import model Customer
use App\Models\Payment; // Import model Payment

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'customer_id', // Tambahkan kolom customer_id ke fillable
        'shipping_date',
        'tracking_code',
        'status',
        'courier',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id'); // Definisikan relasi dengan Customer
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id', 'order_id'); // Definisikan relasi dengan Payment
    }
}
