<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileAdminController extends Controller
{
    public function index()
{
    $user = Auth::user();
    return view('admin.profile-admin.profile-admin', compact('user'));
}

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.auth()->id(),
            'password' => 'nullable|string|min:8',
        ]);

        $user = User::find(auth()->id());
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect('/dashboard')->with('success', 'Profile updated successfully.');
    }
}
