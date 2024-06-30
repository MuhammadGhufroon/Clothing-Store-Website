<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Delivery; // Tambahkan ini jika belum ada
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;


class ProfileCustomerController extends Controller
{


    public function index()
    {
        // Mendapatkan data pengguna yang sedang login
        $customer = Auth::user();
    
        // Mendapatkan daftar kota dari API
        $citiesResponse = Http::withHeaders([
            'key'=> '977ca5db4e4cafbd504ced6cc96428e1' // Tambahkan kunci API di sini
        ])->get('https://api.rajaongkir.com/starter/city');
    
        // Periksa apakah respons dari API kota berhasil
        if ($citiesResponse->successful()) {
            $citiesData = $citiesResponse->json();
            // Periksa apakah ada kunci 'rajaongkir' dan 'results'
            if (isset($citiesData['rajaongkir']['results'])) {
                $cities = $citiesData['rajaongkir']['results'];
            } else {
                $cities = [];
            }
        } else {
            // Jika respons tidak berhasil, set $cities ke array kosong
            $cities = [];
        }
    
        // Mendapatkan daftar provinsi dari API
        $provincesResponse = Http::withHeaders([
            'key'=> '977ca5db4e4cafbd504ced6cc96428e1' // Tambahkan kunci API di sini
        ])->get('https://api.rajaongkir.com/starter/province');
    
    
        // Periksa apakah respons dari API provinsi berhasil
        if ($provincesResponse->successful()) {
            $provincesData = $provincesResponse->json();
            // Periksa apakah ada kunci 'rajaongkir' dan 'results'
            if (isset($provincesData['rajaongkir']['results'])) {
                $provinces = $provincesData['rajaongkir']['results'];
            } else {
                $provinces = [];
            }
        } else {
            // Jika respons tidak berhasil, set $provinces ke array kosong
            $provinces = [];
        }
    
        return view('frontend.profile-customer.profile-customer', compact('customer', 'cities', 'provinces'));
    }
    



    public function update(Request $request)
{
    // Validasi input
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:customers,email,' . Auth::id(),
        'phone' => 'required|string|max:20',
        'address1' => 'required|string|max:255',
        'address2' => 'nullable|string|max:255',
        'address3' => 'nullable|string|max:255',
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    // Dapatkan data pengguna yang sedang login
    $customer = Auth::user();

    // Update data pengguna
    $customer->name = $request->name;
    $customer->email = $request->email;
    $customer->phone = $request->phone;
    $customer->address1 = $request->address1;
    $customer->address2 = $request->address2;
    $customer->address3 = $request->address3;

    // Jika password diisi, update password
    if ($request->filled('password')) {
        $customer->password = bcrypt($request->password);
    }

    // Simpan perubahan
    $customer->save();


    // Redirect dengan pesan sukses
    return redirect('/cart')->with('success', 'Profile updated successfully!');
}

public function updateProfilePicture(Request $request)
{
    $request->validate([
        'profile_picture' => 'required|image|mimes:jpeg,png,gif,webp|max:5048', // max 5 MB
    ]);

    $customer = Auth::user();

    // Hapus gambar lama jika ada
    if ($customer->profile_picture) {
        File::delete($customer->profile_picture); // Hapus gambar lama dari storage
    }

    // Simpan gambar baru
    $imagePath = $request->file('profile_picture')->store('profile_pictures', 'public');
    $customer->profile_picture = $imagePath;
    $customer->save();

    return redirect('/profile/customer')->with('success', 'Profile picture updated successfully!');
}



public function receivePackage(Request $request)
{
    // Temukan pengiriman yang belum diterima oleh pengguna saat ini
    $delivery = Delivery::where('status', 'On the way')
                        ->where('customer_id', Auth::id())
                        ->first();

    // Periksa apakah ada pengiriman yang belum diterima
    if (!$delivery) {
        return redirect()->back()->with('error', 'No pending delivery found.');
    }

    // Perbarui status pengiriman menjadi "Package has arrived"
    $delivery->status = 'Package has arrived';
    $delivery->save();

    return redirect()->back()->with('success', 'Package received successfully.');
}


}
