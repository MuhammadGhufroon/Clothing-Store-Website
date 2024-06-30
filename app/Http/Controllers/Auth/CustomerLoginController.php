<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AuthenticateCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use Illuminate\Support\Facades\Redirect;

class CustomerLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.customer.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);
    
        $credentials = $request->only('password');
        if (filter_var($request->login, FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $request->login;
        } else {
            $credentials['name'] = $request->login;
        }
    
        $password = $request->input('password');
    
        $user = Customer::where('email', $credentials['email'] ?? null)
                        ->orWhere('name', $credentials['name'] ?? null)
                        ->first();
    
        if ($user && Hash::check($password, $user->password)) {
            Auth::guard('customers')->login($user);
    
            return redirect('/category');

        }

        return back()->withErrors(['login' => 'Nama lengkap atau email, atau password salah.'])->withInput($request->only('login'));
    }
}

