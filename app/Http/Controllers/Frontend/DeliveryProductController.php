<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\Delivery;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DeliveryProductController extends Controller
{
    // Fungsi untuk menampilkan halaman pengiriman produk
    public function index()
    {
        // Memperbarui status pengiriman sebelum menampilkan halaman
        $this->updateDeliveryStatus();

        // Mendapatkan data pengguna yang sedang login
        $customer = Auth::user();

        // Mendapatkan semua data pengiriman milik pengguna yang sedang login
        $deliveries = Delivery::where('customer_id', $customer->id)->get();

        // Mendapatkan informasi pengiriman terkini
        $delivery = $deliveries->last();

        // Jika pengiriman terkini ditemukan, ambil pesanannya
        $order = $delivery ? $delivery->order : null;

        // Mengirim data pengiriman dan pesanan terkini ke tampilan Blade
        return view('frontend.delivery-product.delivery-product', compact('deliveries', 'delivery', 'order'));
    }

    // Fungsi untuk menerima paket
    public function receivePackage(Request $request)
    {
        // Temukan pengiriman yang belum diterima oleh pengguna saat ini
        $delivery = Delivery::where('status', 'On the way')
                            ->where('customer_id', Auth::id()) // Menggunakan informasi pengguna yang sedang login
                            ->first();

        // Periksa apakah ada pengiriman yang belum diterima
        if (!$delivery) {
            return redirect()->back()->with('error', 'No pending delivery found.');
        }

        // Perbarui status pengiriman menjadi "Package has arrived"
        $delivery->status = 'Package has arrived';
        $delivery->save();

        return redirect()->back()->with('success', 'Package received successfully.');
    }

    // Fungsi untuk membatalkan pesanan
    public function cancelOrder($orderId)
    {
        // Temukan pengiriman terkait dengan pesanan yang akan dibatalkan
        $delivery = Delivery::where('order_id', $orderId)
                            ->where('customer_id', Auth::id()) // Memastikan pengiriman milik pengguna yang sedang login
                            ->first();

        // Periksa apakah pengiriman ditemukan
        if (!$delivery) {
            return redirect()->back()->with('error', 'Delivery not found.');
        }

        // Temukan pembayaran terkait dengan pesanan yang akan dibatalkan
        $payment = Payment::where('order_id', $orderId)->first();

        // Hapus pembayaran jika ditemukan
        if ($payment) {
            $payment->delete();
        }

        // Hapus pengiriman terkait
        $delivery->delete();

        // Hapus pesanan terkait
        Order::find($orderId)->delete();

        return redirect()->back()->with('success', 'Order canceled successfully.');
    }

    // Fungsi untuk menghapus riwayat pesanan
    public function deleteOrderHistory($deliveryId)
    {
        // Temukan pengiriman terkait
        $delivery = Delivery::where('id', $deliveryId)
                            ->where('customer_id', Auth::id()) // Memastikan pengiriman milik pengguna yang sedang login
                            ->first();

        // Periksa apakah pengiriman ditemukan
        if (!$delivery) {
            return redirect()->back()->with('error', 'Delivery not found.');
        }

        // Hapus pengiriman terkait
        $delivery->delete();

        return redirect()->back()->with('success', 'Order history deleted successfully.');
    }

    // Fungsi untuk memperbarui status pengiriman
    public function updateDeliveryStatus()
    {
        $oneWeekAgo = Carbon::now()->subWeek();
        $deliveries = Delivery::where('status', 'On the way')
                              ->where('customer_id', Auth::id()) // Memastikan pengiriman milik pengguna yang sedang login
                              ->get();

        foreach ($deliveries as $delivery) {
            if ($delivery->updated_at < $oneWeekAgo) {
                $delivery->status = 'Package has arrived';
                $delivery->save();
            }
        }
    }
}
