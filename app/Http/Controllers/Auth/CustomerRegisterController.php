<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;

class CustomerRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('admin.customer.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:customers',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:8|confirmed',          
        ]);

        Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),         
        ]);
        

        return redirect()->route('customer.login')->with('success', 'Registration successful! Please login.');
    }
}
