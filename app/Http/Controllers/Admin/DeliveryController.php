<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Order; 
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    
    public function index()
    {
        $deliveries = Delivery::all();
        return view('admin.delivery.index', compact('deliveries'));
    }


    public function create()
    {
        $orders = Order::all(); // Mengambil semua order dari tabel orders
        return view('admin.delivery.create', compact('orders'));
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'shipping_date' => 'required|date',
            'tracking_code' => 'required|string|max:255',
            'status' => 'required|string|max:100',
        ]);

        Delivery::create($request->all());

        return redirect()->route('delivery.index')->with('success', 'Delivery created successfully');
    }

   
public function edit($id)
{
    $delivery = Delivery::findOrFail($id);
    
    $orders = Order::all(); 

    return view('admin.delivery.edit', compact('delivery', 'orders'));
}

 
    public function update(Request $request, $id)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'shipping_date' => 'required|date',
            'tracking_code' => 'required|string|max:255',
            'status' => 'required|string|max:100',
        ]);

        $delivery = Delivery::findOrFail($id);
        $delivery->update($request->all());

        return redirect()->route('delivery.index')->with('success', 'Delivery updated successfully');
    }


    public function destroy($id)
    {
        $delivery = Delivery::findOrFail($id);
        $delivery->delete();

        return redirect()->route('delivery.index')->with('success', 'Delivery deleted successfully');
    }

    
}