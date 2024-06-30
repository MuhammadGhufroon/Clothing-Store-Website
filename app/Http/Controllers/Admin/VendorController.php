<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vendor;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::all();
        return view('admin.vendor.index', compact('vendors'));
    }

    public function create()
    {
        return view('admin.vendor.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:vendors',
        'phone' => 'required|string|max:20',
        'address' => 'required|string|max:255',
    ]);

    Vendor::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'address' => $request->address,
    ]);

    return redirect()->route('vendor.index')->with('success', 'Vendor created successfully.');
}


    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('admin.vendor.edit', compact('vendor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:vendors,email,'.$id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        $vendor = Vendor::findOrFail($id);
        $vendor->name = $request->name;
        $vendor->email = $request->email;
        $vendor->phone = $request->phone;
        $vendor->address = $request->address;

        $vendor->save();

        return redirect()->route('vendor.index')->with('success', 'Vendor updated successfully.');
    }

    public function destroy($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();
        
        return redirect()->route('vendor.index')->with('success', 'Vendor deleted successfully.');
    }
}
