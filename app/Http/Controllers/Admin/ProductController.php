<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::all();
        return view('admin.product.index', compact('products'));
    }

  
    public function create()
    {
        $categories = ProductCategory::all();
        return view('admin.product.create', compact('categories'));
    }


    // UserController.php

public function store(Request $request)
{
    $request->validate([
        'product_category_id' => 'required|exists:product_categories,id',
        'product_name' => 'required|string|max:100|unique:products,product_name',
        'description' => 'required|string',
        'price' => 'required|integer',
        'image1_url' => 'nullable|image|max:20048',
        'image2_url' => 'nullable|image|max:20048',
        'image3_url' => 'nullable|image|max:20048',
        'image4_url' => 'nullable|image|max:20048',
        'image5_url' => 'nullable|image|max:20048',
    ]);

    $imagePaths = [];
    for ($i = 1; $i <= 5; $i++) {
        if ($request->hasFile('image'.$i.'_url')) {
            $image = $request->file('image'.$i.'_url');
            $imageName = 'product_' . $i . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/product_images'), $imageName);
            $imagePaths['image'.$i.'_url'] = 'storage/product_images/' . $imageName;
        }
    }

    // Menambahkan nilai default 0 untuk stock_quantity
    $requestData = $request->except(['_token', '_method']);
    $requestData = array_merge($requestData, ['stok_quantity' => 0], $imagePaths);

    Product::create($requestData);

    return redirect()->route('product.index')->with('success', 'Product created successfully');
}


    
    public function edit($id)
{
    $product = Product::findOrFail($id);

    $categories = ProductCategory::all();

    return view('admin.product.edit', compact('product', 'categories'));
}

 
public function update(Request $request, Product $product)
{
    $rules = [
        'product_category_id' => 'required|exists:product_categories,id',
        'product_name' => ['required', 'string', 'max:100', Rule::unique('products')->ignore($product->id)],
        'description' => 'required|string',
        'price' => 'required|integer',
        'image1_url' => 'nullable|image|max:20048',
        'image2_url' => 'nullable|image|max:20048',
        'image3_url' => 'nullable|image|max:20048',
        'image4_url' => 'nullable|image|max:20048',
        'image5_url' => 'nullable|image|max:20048',
    ];

    for ($i = 1; $i <= 5; $i++) {
        if ($request->hasFile("image{$i}_url")) {
            $rules["image{$i}_url"] = 'image|max:20048';
        }
    }

    $request->validate($rules);

    // Hapus pembaruan untuk stock_quantity
    $product->update($request->except(['_token', '_method', 'image1_url', 'image2_url', 'image3_url', 'image4_url', 'image5_url']));

    $imagePaths = [];
    for ($i = 1; $i <= 5; $i++) {
        if ($request->hasFile("image{$i}_url")) {
            $image = $request->file("image{$i}_url");
            $imageName = 'products_' . $i . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/product_images'), $imageName);
            $imagePaths["image{$i}_url"] = 'storage/product_images/' . $imageName;
        }
    }

    // Perbarui hanya atribut-atribut yang diperlukan
    $product->update($request->except(['_token', '_method', 'image1_url', 'image2_url', 'image3_url', 'image4_url', 'image5_url']) + $imagePaths);

    return redirect()->route('product.index')->with('success', 'Product updated successfully');
}



    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product deleted successfully');
    }
}