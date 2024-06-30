<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::all();
        return view('admin.product-category.index', compact('categories'));
    }

    public function create()
{
    return view('admin.product-category.create');
}

    public function edit($id)
    {
        $category = ProductCategory::findOrFail($id);
        return view('admin.product-category.edit', compact('category'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'category_name' => 'required|string|max:255|unique:product_categories,category_name,'.$id,
    ]);

    $category = ProductCategory::findOrFail($id);
    $category->update($request->all());

    return redirect()->route('product-category.index')->with('success', 'Product category updated successfully');
}


    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255|unique:product_categories',
        ]);

        ProductCategory::create($request->all());

        return redirect()->route('product-category.index')->with('success', 'Product category created successfully');
    }

    public function destroy($id)
    {
        $category = ProductCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('product-category.index')->with('success', 'Product category deleted successfully');
    }
}
