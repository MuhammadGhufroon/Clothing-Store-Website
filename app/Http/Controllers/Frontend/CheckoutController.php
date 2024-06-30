<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Discount;
use App\Models\Delivery;
use App\Models\Customer;
use Illuminate\Support\Facades\Redirect;
use Midtrans;

class CheckoutController extends Controller
{
 
    public function showCheckout()
{
    $customer = Auth::user();

    // Ambil pesanan yang masih dalam status "pending" untuk pengguna saat ini
    $order = Order::where('customer_id', $customer->id)
                  ->where('status', 'pending')
                  ->first();

    if (!$order) {
        // Jika pesanan tidak ditemukan, kembalikan dengan pesan kesalahan
        return back()->withErrors(['msg' => 'No pending order found for the user.']);
    }

    // Ubah status pesanan menjadi "Unpaid"
    $order->status = 'Unpaid';
    $order->save();

    // Midtrans configuration
    \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
    \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
    \Midtrans\Config::$isSanitized = config('services.midtrans.is_sanitized');
    \Midtrans\Config::$is3ds = config('services.midtrans.is_3ds');

    // Buat parameter transaksi untuk Midtrans
    $params = [
        'transaction_details' => [
            'order_id' => $order->id,
            'gross_amount' => $order->total_amount,
        ],
        'customer_details' => [
            'first_name' => $customer->name,
            'email' => $customer->email,
            'phone' => $customer->phone,
        ],
    ];

    try {
        // Dapatkan Snap Token dari Midtrans
        $snapToken = \Midtrans\Snap::getSnapToken($params);
    } catch (\Exception $e) {
        // Tangani kesalahan jika ada masalah dengan API Midtrans
        return back()->withErrors(['msg' => 'Error processing payment: ' . $e->getMessage()]);
    }

    // Menghapus semua item keranjang yang terkait dengan pengguna saat ini
    $cartItems = OrderDetail::where('order_id', $order->id)->get();
    foreach ($cartItems as $item) {
        $item->delete();
    }

    // Menghitung biaya pengiriman acak
    $shippingCost = $this->calculateShippingCost();

    return view('frontend.checkout.checkout', [
        'cartItems' => $cartItems,
        'subtotal' => $order->total_amount, // Menggunakan total_amount dari pesanan
        'total' => $order->total_amount + $shippingCost, // Total termasuk biaya pengiriman
        'shippingCost' => $shippingCost, // Menyertakan biaya pengiriman ke tampilan
        'order_date' => $order->order_date->format('Y-m-d'),
        'customer' => $customer,
        'snapToken' => $snapToken, // Menyertakan Snap Token ke tampilan
        'order_id' => $order->id,
        // Kemungkinan variabel lain yang ingin Anda lewatkan ke tampilan
    ]);
}



public function createPayment(Request $request)
{
    // Validasi request
    $request->validate([
        'order_id' => 'required|exists:orders,id',
        'payment_method' => 'required|string',
        'amount' => 'required|numeric',
    ]);

    // Buat rekaman pembayaran baru
    $payment = new Payment();
    $payment->order_id = $request->order_id;
    $payment->payment_date = now();
    $payment->payment_method = $request->payment_method;
    $payment->amount = $request->amount;
    $payment->save();

    return response()->json(['success' => true, 'message' => 'Payment record created successfully.']);
}



public function updateOrderStatus(Request $request, $id)
{
    // Validasi status dan kurir
    $request->validate([
        'status' => 'required|string',
        'courier' => 'required|string',
    ]);

    // Temukan pesanan berdasarkan ID
    $order = Order::find($id);

    if (!$order) {
        return response()->json(['success' => false, 'error' => 'Order not found.']);
    }

    // Update status pengiriman dan kurir di tabel deliveries
    $delivery = Delivery::where('order_id', $order->id)->first();
    if (!$delivery) {
        return response()->json(['success' => false, 'error' => 'Delivery not found.']);
    }
    $delivery->status = $request->status;
    $delivery->courier = $request->courier;
    $delivery->save();

    // Hapus data dari tabel order_details jika status pembayaran adalah 'Paid'
    if ($request->status === 'Paid') {
        $order->orderDetails()->delete();
    }

    return response()->json(['success' => true, 'message' => 'Order status updated successfully.']);
}



    public function proceedToCheckout()
    {
        $customer = Auth::user();
        
        // Periksa jika ada kolom yang kosong
        if (empty($customer->phone) || empty($customer->address1) || empty($customer->address2) || empty($customer->address3)) {
            return Redirect::route('customer.profile')->with('error', 'Please fill in all required fields before proceeding to checkout.');
        }
    
        // Jika semua kolom diisi, alihkan ke halaman checkout
        return redirect('/checkout');
    }



public function createDeliveryRecord(Request $request)
{
    // Validasi request
    $request->validate([
        'order_id' => 'required|exists:orders,id',
        'courier' => 'required|string',
    ]);

    // Temukan pesanan berdasarkan ID
    $order = Order::findOrFail($request->order_id);

    // Dapatkan ID pelanggan dari pesanan
    $customerId = $order->customer_id;

    try {
        // Buat rekaman pengiriman baru dengan menyertakan customer_id
        $delivery = new Delivery();
        $delivery->order_id = $order->id;
        $delivery->customer_id = $customerId; // Sertakan customer_id
        $delivery->shipping_date = now(); // atau sesuaikan dengan tanggal pengiriman yang diinginkan
        $delivery->tracking_code = 'TRK' . uniqid(); // Sesuaikan dengan kode pelacakan yang sebenarnya jika ada
        $delivery->status = 'Package being packed';
        $delivery->courier = $request->courier; // Tambahkan data kurir dari permintaan
        $delivery->save();

        return response()->json(['success' => true, 'message' => 'Delivery record created successfully.']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'error' => $e->getMessage()]);
    }
}



public function updateOrderAndDeliveryStatus(Request $request, $id)
{
    // Validasi request
    $request->validate([
        'order_status' => 'required|string',
        'delivery_status' => 'required|string',
        'courier' => 'required|string',
    ]);

    // Temukan pesanan berdasarkan ID
    $order = Order::find($id);

    if (!$order) {
        return response()->json(['success' => false, 'error' => 'Order not found.']);
    }

    // Perbarui status pesanan
    $order->status = $request->order_status;
    $order->save();

    // Temukan atau buat rekaman pengiriman baru
    $delivery = Delivery::where('order_id', $order->id)->first();
    if (!$delivery) {
        $delivery = new Delivery();
        $delivery->order_id = $order->id;
        $delivery->customer_id = $order->customer_id;
    }

    // Perbarui status pengiriman dan kurir
    $delivery->status = $request->delivery_status;
    $delivery->courier = $request->courier;
    $delivery->shipping_date = now(); // atau sesuaikan dengan tanggal pengiriman yang diinginkan
    $delivery->tracking_code = 'TRK' . uniqid(); // Sesuaikan dengan kode pelacakan yang sebenarnya jika ada
    $delivery->save();

    return response()->json(['success' => true, 'message' => 'Order and Delivery status updated successfully.']);
}

public function calculateShippingCost() {
    // Generate biaya pengiriman acak dari rentang Rp 10.000 hingga Rp 100.000
    $shippingCost = rand(10000, 50000);

    return $shippingCost;
}


}