<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\Customer;

class WishlistproductController extends Controller
{
    
    public function index(Request $request)
{
    // Ambil data produk dari wishlist pengguna yang saat ini login
    $wishlistProducts = Wishlist::where('customer_id', Auth::id())
        ->with('product') // Pastikan untuk mengambil data produk yang terkait dengan setiap wishlist
        ->get();

    // Inisialisasi variabel untuk menyimpan total harga diskon
    $totalDiscountedPrice = 0;

    // Iterasi setiap produk dalam wishlist untuk menghitung total harga diskon
    foreach ($wishlistProducts as $wishlistProduct) {
        // Cek apakah produk memiliki diskon
        $discount = $wishlistProduct->product->discounts->first(); // Ambil data diskon pertama (jika ada)
        if ($discount && $discount->percentage > 0) {
            // Hitung harga diskon
            $discountedPrice = $wishlistProduct->product->price - ($wishlistProduct->product->price * $discount->percentage / 100);
            // Tambahkan harga diskon ke total harga diskon
            $totalDiscountedPrice += $discountedPrice;
            // Set harga produk menjadi harga diskon
            $wishlistProduct->product->price = $discountedPrice;
        } else {
            // Jika produk tidak memiliki diskon, gunakan harga normal
            $totalDiscountedPrice += $wishlistProduct->product->price;
        }
    }

    // Hitung jumlah produk dalam wishlist
    $wishlistCount = $wishlistProducts->count();

    // Kirimkan total harga diskon ke view
    return view('frontend.wishlist-product.wishlist-product', compact('wishlistProducts', 'wishlistCount', 'totalDiscountedPrice'));
}



public function addToWishlist(Request $request)
{
    // Validasi request
    $request->validate([
        'product_id' => 'required|exists:products,id',
    ]);

    $selectedImage = $request->input('selected_image');

    // Cek apakah pengguna sudah login
    if (Auth::check()) {
        // Cek apakah produk sudah ada di wishlist pengguna
        $existingWishlist = Wishlist::where('customer_id', Auth::id())
            ->where('product_id', $request->input('product_id'))
            ->first();

        // Jika produk belum ada di wishlist, tambahkan ke dalam wishlist
        if (!$existingWishlist) {
            $wishlist = new Wishlist();
            $wishlist->customer_id = Auth::id();
            $wishlist->product_id = $request->input('product_id');
            $wishlist->selected_image = $selectedImage; // Simpan gambar yang dipilih
            $wishlist->save();

            // Tampilkan Sweet Alert untuk memberi notifikasi kepada pengguna
            return redirect()->route('wishlist-product.index')->with('success', 'Product has been added to wishlist.');
        }

        return redirect()->route('wishlist-product.index')->with('error', 'Product is already in wishlist.');
    } else {
        return redirect()->route('customer.login')->with('error', 'Please login to add product to wishlist.');
    }
}




public function destroy($id)
{
    // Temukan dan hapus item wishlist berdasarkan ID
    $wishlistItem = Wishlist::findOrFail($id);

    // Pastikan item wishlist milik pengguna yang saat ini login
    if ($wishlistItem->customer_id === Auth::id()) {
        $wishlistItem->delete();
        return redirect()->route('wishlist-product.index')->with('success', 'Product has been removed from wishlist.');
    } else {
        return redirect()->route('wishlist-product.index')->with('error', 'You are not authorized to delete this item.');
    }
}

// Fungsi untuk menampilkan wishlist
public function showWishlist()
{
    // Logika untuk menghitung jumlah produk dalam wishlist
    if (Auth::check()) {
        $user = Auth::user();
        $wishlistItemCount = Wishlist::where('customer_id', $user->id)->count();
    } else {
        $wishlistItemCount = 0; // Jika pengguna tidak masuk, jumlah item wishlist adalah 0
    }

    return view('frontend.wishlist.wishlist', [
        'wishlistItemCount' => $wishlistItemCount,
    ]);
}

}
