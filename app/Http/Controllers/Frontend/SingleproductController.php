<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Discount;
use App\Models\ProductReview;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SingleproductController extends Controller
{
    public function show($id)
    {
        try {
            $product = Product::with('reviews')->findOrFail($id);

            // Ambil diskon jika ada
            $discount = Discount::where('product_id', $id)->first();

            // Cek apakah produk memiliki diskon dan apakah diskon masih berlaku
            if ($discount && Carbon::now()->between($discount->start_date, $discount->end_date)) {
                $discountedPrice = $product->price - ($product->price * $discount->percentage / 100);
                $product->discounted_price = $discountedPrice;
                $product->discount_category_name = optional($discount->categoryDiscount)->category_name;
                $product->discount = $discount;
            }

            $imageUrls = [];
            for ($i = 1; $i <= 5; $i++) {
                $imageUrls[] = asset('storage/product_images/' . $product->id . '/' . $product->{'image'.$i.'_url'});
            }

            return view('frontend.single-product.single-product', compact('product', 'imageUrls'));
        } catch (ModelNotFoundException $e) {
            abort(404); // Produktidak ditemukan, kembalikan respons 404
        }
    }

    public function submitReview(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        // Buat instance ProductReview
        $review = new ProductReview();
        $review->product_id = $id;
        $review->customer_id = Auth::id(); // Ambil ID pengguna yang sedang login
        $review->rating = $request->input('rating');
        $review->comment = $request->input('comment');
        $review->save();

        // Redirect kembali ke halaman produk dengan pesan sukses atau melakukan tindakan lainnya
        return redirect()->back()->with('success', 'Review submitted successfully.');
    }
    

    public function deleteReview($id)
{
    try {
        $review = ProductReview::findOrFail($id);

        // Periksa apakah pengguna yang mencoba menghapus ulasan adalah pemilik ulasan
        if ($review->customer_id == Auth::id()) {
            $review->delete();
            return redirect()->back()->with('success', 'Review deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'You are not authorized to delete this review.');
        }
    } catch (ModelNotFoundException $e) {
        abort(404); // Ulasan tidak ditemukan, kembalikan respons 404
    }
}

}