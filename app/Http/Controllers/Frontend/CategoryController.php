<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\DiscountCategory;
use App\Models\Discount;
use Carbon\Carbon;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = $request->input('category_id');
        $discountCategoryId = $request->input('discount_category_id');

        $productsQuery = Product::query();

        if ($categoryId) {
            $categoryIdArray = explode(',', $categoryId);
            $productsQuery->whereIn('product_category_id', $categoryIdArray);
        }

        if ($discountCategoryId) {
            $discountProducts = Discount::where('category_discount_id', $discountCategoryId)->pluck('product_id');
            $productsQuery->whereIn('id', $discountProducts);
        }

        $products = $productsQuery->paginate(9);
        $discounts = Discount::whereIn('product_id', $products->pluck('id'))->get();
        $discountCategories = DiscountCategory::all();
        $categories = ProductCategory::all();
        $currentDate = Carbon::now();

        foreach ($products as $product) {
            $productDiscount = $discounts->where('product_id', $product->id)->first();
            if ($productDiscount && $currentDate->between($productDiscount->start_date, $productDiscount->end_date)) {
                $product->percentage = $productDiscount->percentage;
                $discountedPrice = $product->price - ($product->price * $productDiscount->percentage / 100);
                $product->discounted_price = $discountedPrice;

                $discountCategory = $discountCategories->where('id', $productDiscount->category_discount_id)->first();
                if ($discountCategory) {
                    $product->discount_category_name = $discountCategory->category_name;
                }
            }
        }

        return view('frontend.category.category', compact('products', 'categories', 'categoryId', 'discountCategories', 'discountCategoryId'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $products = Product::where('product_name', 'like', '%' . $keyword . '%')->paginate(9);
        $categories = ProductCategory::all();
        $categoryId = $request->input('category_id');
        $discountCategoryId = $request->input('discount_category_id');
        $discountCategories = DiscountCategory::all();

        return view('frontend.category.category', compact('products', 'categories', 'categoryId', 'discountCategories', 'discountCategoryId'));
    }
}

