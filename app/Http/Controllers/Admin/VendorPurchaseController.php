<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VendorPurchase;
use App\Models\Product;
use App\Models\Vendor;

class VendorPurchaseController extends Controller
{
    public function index()
    {
        $purchases = VendorPurchase::with('vendor', 'product')->get();
        return view('admin.vendor-purchase.index', compact('purchases'));
    }

    public function purchaseForm()
    {
        $products = Product::all();
        $vendors = Vendor::all();
        return view('admin.vendor-purchase.purchase', compact('products', 'vendors'));
    }

    public function purchase(Request $request)
{
    $request->validate([
        'vendor_id' => 'required|exists:vendors,id',
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);

    $product = Product::findOrFail($request->product_id);
    $adjustedPrice = max($product->price - 10000, 0); // Mengurangi harga produk sebesar 100000, dan memastikan tidak menjadi negatif
    $totalAmount = $adjustedPrice * $request->quantity;

    // Update stok produk
    $product->stok_quantity += $request->quantity;
    $product->save();

    // Buat record baru di VendorPurchase
    VendorPurchase::create([
        'vendor_id' => $request->vendor_id,
        'product_id' => $request->product_id,
        'quantity' => $request->quantity,
        'transaction_date' => now(), // Menambahkan tanggal transaksi
        'total_amount' => $totalAmount, // Menghitung total harga
    ]);

    return redirect()->route('vendor.purchase.index')->with('success', 'Stock purchased successfully.');
}


    public function edit($id)
    {
        $purchase = VendorPurchase::findOrFail($id);
        $products = Product::all();
        $vendors = Vendor::all();
        return view('admin.vendor-purchase.edit', compact('purchase', 'products', 'vendors'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $purchase = VendorPurchase::findOrFail($id);
        $product = Product::findOrFail($request->product_id);

        // Menghitung selisih jumlah baru dengan jumlah lama
        $quantityDifference = $request->quantity - $purchase->quantity;
        $product->stok_quantity += $quantityDifference;
        $product->save();

        $purchase->update([
            'vendor_id' => $request->vendor_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'transaction_date' => now(), // Memperbarui tanggal transaksi
            'total_amount' => $product->price * $request->quantity, // Memperbarui total harga
        ]);

        return redirect()->route('vendor.purchase.index')->with('success', 'Purchase updated successfully.');
    }

    public function destroy($id)
    {
        $purchase = VendorPurchase::findOrFail($id);
        $purchase->delete();

        return redirect()->back()->with('success', 'Purchase deleted successfully.');
    }
}
