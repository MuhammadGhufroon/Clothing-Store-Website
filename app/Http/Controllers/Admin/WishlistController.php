<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Customer;
use App\Models\Product;

class WishlistController extends Controller
{
    
    public function index()
    {
        $wishlists = Wishlist::all();
        return view('admin.wishlist.index', compact('wishlists'));
    }


    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('admin.wishlist.create', compact('customers', 'products'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
        ]);

        Wishlist::create($request->all());

        return redirect()->route('wishlist.index')->with('success', 'Wishlist created successfully');
    }

    
    public function edit($id)
    {
        $wishlist = Wishlist::findOrFail($id);
        $customers = Customer::all();
        $products = Product::all();
        return view('admin.wishlist.edit', compact('wishlist', 'customers', 'products'));
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
        ]);

        $wishlist = Wishlist::findOrFail($id);
        $wishlist->update($request->all());

        return redirect()->route('wishlist.index')->with('success', 'Wishlist updated successfully');
    }

   
    public function destroy($id)
    {
        $wishlist = Wishlist::findOrFail($id);
        $wishlist->delete();

        return redirect()->route('wishlist.index')->with('success', 'Wishlist deleted successfully');
    }
}
