<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Order;

class OrderDetailController extends Controller
{

    public function index()
    {
        $orderDetails = OrderDetail::all();
        return view('admin.order-detail.index', compact('orderDetails'));
    }

    public function create()
    {
        $products = Product::all();
        $orders = Order::all();
        return view('admin.order-detail.create', compact('products', 'orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_id' => 'required|exists:orders,id',
            'quantity' => 'required|integer',
            'subtotal' => 'required|integer',
        ]);

        OrderDetail::create($request->all());

        return redirect()->route('order-detail.index')->with('success', 'Order detail created successfully');
    }


    public function edit($id)
    {
        $orderDetail = OrderDetail::findOrFail($id);
        $products = Product::all();
        $orders = Order::all();
        return view('admin.order-detail.edit', compact('orderDetail', 'products', 'orders'));
    }

 
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_id' => 'required|exists:orders,id',
            'quantity' => 'required|integer',
            'subtotal' => 'required|integer',
        ]);

        $orderDetail = OrderDetail::findOrFail($id);
        $orderDetail->update($request->all());

        return redirect()->route('order-detail.index')->with('success', 'Order detail updated successfully');
    }


    public function destroy($id)
    {
        $orderDetail = OrderDetail::findOrFail($id);
        $orderDetail->delete();

        return redirect()->route('order-detail.index')->with('success', 'Order detail deleted successfully');
    }
}
