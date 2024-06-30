<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountCategory;
use Illuminate\Http\Request;


class DiscountCategoryController extends Controller
{
    
    public function index()
    {
        $categories = DiscountCategory::all();
        return view('admin.discount-category.index', compact('categories'));
    }

    
    public function create()
    {
        return view('admin.discount-category.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:100',
        ]);

        DiscountCategory::create($request->only('category_name'));

        return redirect()->route('discount-category.index')->with('success', 'Discount category created successfully');
    }

   
    public function edit($id)
    {
        $category = DiscountCategory::findOrFail($id);
        return view('admin.discount-category.edit', compact('category'));
    }

    
    public function update(Request $request, DiscountCategory $discountCategory)
    {
        $request->validate([
            'category_name' => 'required|string|max:100',
        ]);

        $discountCategory->update($request->only('category_name'));

        return redirect()->route('discount-category.index')->with('success', 'Discount category updated successfully');
    }


    public function destroy(DiscountCategory $discountCategory)
    {
        $discountCategory->delete();

        return redirect()->route('discount-category.index')->with('success', 'Discount category deleted successfully');
    }
}

