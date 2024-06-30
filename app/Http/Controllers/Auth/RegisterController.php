<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect('register')
                ->withErrors($validator)
                ->withInput();
        }

        $existingUserByName = User::where('name', $request->name)->first();
        if ($existingUserByName) {
            return redirect('register')
                ->with('error', 'Nama pengguna sudah digunakan.')
                ->withInput()
                ->with('registerError', 'name');
        }

        $existingUserByEmail = User::where('email', $request->email)->first();
        if ($existingUserByEmail) {
            return redirect('register')
                ->with('error', 'Email sudah digunakan.')
                ->withInput()
                ->with('registerError', 'email');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect('login')->with('success', 'Akun berhasil dibuat. Silakan masuk.');
    }
}



