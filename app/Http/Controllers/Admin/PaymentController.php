<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::all();
        return view('admin.payment.index', compact('payments'));
    }


    public function create()
    {
        $orders = Order::all();
        return view('admin.payment.create', compact('orders'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string|max:255',
            'amount' => 'required|integer',
        ]);

        Payment::create($request->all());

        return redirect()->route('payment.index')->with('success', 'Payment created successfully');
    }


    public function edit($id)
{
    $payment = Payment::findOrFail($id);
    $orders = Order::all();
    return view('admin.payment.edit', compact('payment', 'orders'));
}


    public function update(Request $request, $id)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string|max:255',
            'amount' => 'required|integer',
        ]);

        $payment = Payment::findOrFail($id);
        $payment->update($request->all());

        return redirect()->route('payment.index')->with('success', 'Payment updated successfully');
    }
 
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return redirect()->route('payment.index')->with('success', 'Payment deleted successfully');
    }
}
