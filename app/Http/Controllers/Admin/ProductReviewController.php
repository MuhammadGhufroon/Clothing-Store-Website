<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use App\Models\Customer;
use App\Models\Product;

class ProductReviewController extends Controller
{
    
    public function index()
    {
        $reviews = ProductReview::all();
        return view('admin.product-review.index', compact('reviews'));
    }


    public function create()
{
    $customers = Customer::all(); 
    $products = Product::all();
    return view('admin.product-review.create', compact('customers', 'products'));
}


    
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        ProductReview::create($request->all());

        return redirect()->route('product-review.index')->with('success', 'Product review created successfully');
    }

    
    public function edit($id)
    {
        $review = ProductReview::findOrFail($id);
        $products = Product::all();
        $customers = Customer::all(); 
        return view('admin.product-review.edit', compact('review', 'products', 'customers'));
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        $review = ProductReview::findOrFail($id);
        $review->update($request->all());

        return redirect()->route('product-review.index')->with('success', 'Product review updated successfully');
    }

    
    public function destroy($id)
    {
        $review = ProductReview::findOrFail($id);
        $review->delete();

        return redirect()->route('product-review.index')->with('success', 'Product review deleted successfully');
    }
}
