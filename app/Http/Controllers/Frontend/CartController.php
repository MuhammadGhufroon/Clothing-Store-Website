<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Wishlist;
use App\Models\Product; 
use App\Models\Discount;
use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{


    public function showCart()
{
    // Mendapatkan pengguna yang terotentikasi
    $user = Auth::user();

    // Mendapatkan data pelanggan
    $customer = Customer::find($user->id);

    // Mengambil semua detail pesanan yang terkait dengan pengguna yang terotentikasi
    $orderDetails = OrderDetail::whereHas('order', function($query) {
        $query->where('customer_id', Auth::id());
    })->with('product')->get();

    // Mendapatkan tanggal pesanan pertama atau menggunakan tanggal sekarang jika tidak ada pesanan
    $order_date = $orderDetails->first() ? $orderDetails->first()->order->order_date : now();

    // Mendapatkan status pesanan pertama atau mengatur ke 'pending' jika tidak ada pesanan
    $status = $orderDetails->first() ? $orderDetails->first()->order->status : 'pending';

    // Mendapatkan ID produk pertama dalam pesanan atau mengatur ke null jika tidak ada produk
    $productId = $orderDetails->first() ? $orderDetails->first()->product->id : null;

    // Inisialisasi totalAmount
    $totalAmount = 0;

    // Menghitung totalAmount dari semua produk dalam pesanan
    foreach ($orderDetails as $orderDetail) {
        $discount = Discount::where('product_id', $orderDetail->product->id)->first();
        if ($discount) {
            $discountedPrice = $orderDetail->product->price - ($orderDetail->product->price * $discount->percentage / 100);
            $totalAmount += $discountedPrice * $orderDetail->quantity;
        } else {
            $totalAmount += $orderDetail->product->price * $orderDetail->quantity;
        }
    }

    // Mengembalikan view dengan data yang diperlukan
    return view('frontend.cart.cart', [
        'orderDetails' => $orderDetails,
        'totalAmount' => $totalAmount,
        'order_date' => $order_date,
        'status' => $status,
        'productId' => $productId,
        'customer' => $customer,
    ]);
}



    // Function untuk menambahkan detail pesanan
    public function addOrderDetail($orderId, $productId, $quantity, $subtotal)
    {
        $orderDetail = new OrderDetail();
        $orderDetail->order_id = $orderId;
        $orderDetail->product_id = $productId;
        $orderDetail->quantity = $quantity;
        $orderDetail->subtotal = $subtotal;
        $orderDetail->save();
    }


// function tombol add di wishlist-product.blade.php
    public function addToCartFromWishlist(Wishlist $wishlistProduct)
    {
        // Validate $wishlistProduct
        if (!$wishlistProduct) {
            return redirect()->back()->with('error', 'Wishlist product not found.');
        }
    
        // Get the authenticated user
        $user = auth()->user();
    
        // Calculate discounted price if available
        $discountedPrice = null;
        $discount = Discount::where('product_id', $wishlistProduct->product_id)->first();
        if ($discount) {
            $discountedPrice = $wishlistProduct->product->price - ($wishlistProduct->product->price * $discount->percentage / 100);
        }
    
        // Add the product to the cart
        $orderDetail = new OrderDetail();
        $order = $user->orders()->create([
            'order_date' => now(),
            'total_amount' => $discountedPrice ? $discountedPrice : $wishlistProduct->product->price,
            'status' => 'pending',
            'quantity' => 1, 
        ]);
        
        $orderDetail->order_id = $order->id;
        $orderDetail->product_id = $wishlistProduct->product_id;
        $orderDetail->quantity = 1;
        $orderDetail->subtotal = $discountedPrice ? $discountedPrice : $wishlistProduct->product->price;
        $orderDetail->save();
    
        // Delete the product from the wishlist
        $wishlistProduct->delete();
    
        return redirect()->route('show-cart')->with('success', 'Product added to cart successfully.');
    }


// function untuk tombol proceed all to cart di wishlist-product.blade.php
public function proceedAllToCart(Request $request)
{
    // Dapatkan semua produk dalam wishlist pengguna
    $wishlistProducts = Wishlist::where('customer_id', $request->user()->id)->get();

    // Loop melalui setiap produk di wishlist dan tambahkan ke keranjang belanja
    foreach ($wishlistProducts as $wishlistProduct) {
        $product = $wishlistProduct->product;

        // Hitung harga setelah diskon, jika ada
        $discountedPrice = $product->price;
        if ($product->discounts->isNotEmpty()) {
            $discountedPrice = $product->price * (100 - $product->discounts->first()->percentage) / 100;
        }

        // Buat request untuk menambahkan produk ke keranjang
        $addToCartRequest = new Request([
            'product_id' => $wishlistProduct->product_id,
            'price' => $discountedPrice,
            // Tambahkan atribut lain yang diperlukan untuk addToCart
        ]);
        $this->addToCart($addToCartRequest);
    }

    // Setelah semua produk ditambahkan, hapus semua entri wishlist untuk pengguna ini
    Wishlist::where('customer_id', $request->user()->id)->delete();

    // Redirect ke halaman keranjang belanja
    return redirect()->route('show-cart');
}



    // function untuk icon cart di category.blade.php dan index.blade.php serta untuk tombol add to cart di single-product.blade.php
    public function addToCart(Request $request)
{
    // Validasi request jika perlu
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'price' => 'required|numeric',
    ]);

    // Temukan produk
    $product = Product::findOrFail($request->product_id);

    // Periksa apakah stok cukup
    if ($product->stok_quantity < $request->quantity) {
        return redirect()->back()->with('error', 'Insufficient stock.');
    }

    // Tentukan harga yang akan digunakan untuk subtotal
    $subtotal = $request->price;

    // Dapatkan atau buat pesanan yang sedang berlangsung untuk pengguna yang sedang terotentikasi
    $order = Order::where('customer_id', Auth::id())->where('status', 'pending')->first();
    if (!$order) {
        $order = new Order();
        $order->customer_id = Auth::id();
        $order->quantity = 0;
        $order->total_amount = 0;
        $order->status = 'pending';
        $order->order_date = now();
        $order->save();
    }

    // Tambahkan detail pesanan
    $this->addOrderDetail($order->id, $request->product_id, 1, $subtotal);

    // Update jumlah dan total_amount pesanan
    $order->quantity += 1;
    $order->total_amount += $subtotal;
    $order->save();

    // Kurangi stok produk
    $product->stok_quantity -= 1;
    $product->save();

    // Redirect atau kembali ke halaman sebelumnya atau ke halaman keranjang
    return redirect()->route('show-cart');
}





public function deleteFromCart($id)
{
    // Cari detail pesanan berdasarkan ID
    $orderDetail = OrderDetail::find($id);

    if ($orderDetail) {
        // Ambil order terkait sebelum menghapus detail pesanan
        $order = $orderDetail->order;

        // Hapus detail pesanan
        $orderDetail->delete();

        // Periksa apakah masih ada detail pesanan untuk order tersebut
        if ($order->orderDetails()->count() > 0) {
            // Perbarui total amount dari pesanan
            $order->total_amount = $order->orderDetails->sum('subtotal');
            $order->save();
        } else {
            // Jika tidak ada detail pesanan yang tersisa, atur total_amount ke 0 atau hapus order
            $order->total_amount = 0;
            $order->save();
            // Atau bisa juga menghapus order
            // $order->delete();
        }
    }

    // Redirect kembali ke halaman cart
    return redirect()->route('show-cart');
}


// CheckoutController.php

public function updateCartQuantity(Request $request, $id)
{
    $orderDetail = OrderDetail::find($id);

    if (!$orderDetail) {
        return response()->json(['success' => false, 'message' => 'Order detail not found']);
    }

    $quantity = $request->quantity;
    $orderDetail->quantity = $quantity;

    // Calculate discounted price if applicable
    if ($orderDetail->product->discounts->isNotEmpty()) {
        $discountPercentage = $orderDetail->product->discounts->first()->percentage;
        $discountedPrice = $orderDetail->product->price * (100 - $discountPercentage) / 100;
        $orderDetail->subtotal = $discountedPrice * $quantity;
    } else {
        $orderDetail->subtotal = $orderDetail->product->price * $quantity;
    }

    $orderDetail->save();

    // Update the total amount of the order
    $order = $orderDetail->order;
    $order->total_amount = $order->orderDetails->sum('subtotal');
    $order->save();

    return response()->json([
        'success' => true,
        'newSubtotal' => $orderDetail->subtotal,
        'newTotalAmount' => $order->total_amount,
    ]);
}


// function notif jumlah product di cart
public function showShop()
{
    // Logic Cart Numbering
    if (Auth::check()) {
        $user = Auth::user();
        // Menghitung jumlah item dalam detail pesanan terkait dengan pesanan yang belum selesai
        $cartItemCount = Order::where('customer_id', $user->id)
            ->where('status', 'pending') // Hanya hitung pesanan yang belum selesai
            ->withCount('orderDetails')
            ->get()
            ->sum('order_details_count');
    } else {
        $cartItemCount = 0; // Jika pengguna belum login, jumlah item di keranjang adalah 0
    }

    return view('frontend.cart.cart', ['cartItemCount' => $cartItemCount]);
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



};
