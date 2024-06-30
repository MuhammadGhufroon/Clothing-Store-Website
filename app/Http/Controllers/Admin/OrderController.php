<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Delivery;

class OrderController extends Controller
{

    public function index()
{
    // Ambil semua pesanan
    $orders = Order::all();

    // Tambahkan variabel delivery untuk setiap pesanan
    foreach ($orders as $order) {
        $order->delivery = Delivery::where('order_id', $order->id)->first();
    }

    return view('admin.order.index', compact('orders'));
}


    public function create()
    {
        $customers = Customer::all();
        return view('admin.order.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'total_amount' => 'required|numeric',
            'status' => 'required|string|max:20',
        ]);

        Order::create($request->all());

        return redirect()->route('order.index')->with('success', 'Order created successfully');
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $customers = Customer::all();
        return view('admin.order.edit', compact('order', 'customers'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'total_amount' => 'required|numeric',
            'status' => 'required|string|max:20',
        ]);

        $order = Order::findOrFail($id);
        $order->update($request->all());

        return redirect()->route('order.index')->with('success', 'Order updated successfully');
    }


    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('order.index')->with('success', 'Order deleted successfully');
    }

    public function deliverOrder($orderId)
    {
        // Retrieve order based on provided ID
        $order = Order::find($orderId);

        // Check if the order exists
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        // Retrieve existing delivery record
        $delivery = Delivery::where('order_id', $order->id)->first();

        if ($delivery) {
            // Update existing delivery record status to 'On the way'
            $delivery->status = 'On the way';
        } else {
            // Retrieve customer based on order
            $customer = Customer::find($order->customer_id);

            // Create a new delivery record if none exists
            $delivery = new Delivery();
            $delivery->order_id = $order->id;
            $delivery->customer_id = $order->customer_id; // Assign customer_id
            $delivery->shipping_date = now();
            $delivery->tracking_code = 'TRK' . uniqid(); // Generate tracking code
            $delivery->status = 'On the way'; // Set initial delivery status
        }

        $delivery->save();

        return redirect()->back()->with('success', 'Delivery status updated to On the way.');
    }

    

}
