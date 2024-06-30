<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{

    public function index()
    {
        $customers = Customer::all();
        return view('admin.customer.index', compact('customers'));
    }

    
    public function create()
    {
        return view('admin.customer.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:255|unique:customers',
            'password' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address1' => 'nullable|string',
            'address2' => 'nullable|string',
            'address3' => 'nullable|string',
        ]);

        Customer::create($request->all());

        return redirect()->route('customer.index')->with('success', 'Customer created successfully');
    }


    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customer.edit', compact('customer'));
    }


    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:255|unique:customers,email,'.$customer->id,
            'password' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address1' => 'nullable|string',
            'address2' => 'nullable|string',
            'address3' => 'nullable|string',
        ]);

        $customer->update($request->all());

        return redirect()->route('customer.index')->with('success', 'Customer updated successfully');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customer.index')->with('success', 'Customer deleted successfully');
    }
}

