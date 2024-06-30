<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact; // Import model Contact

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact.contact');
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari formulir
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Simpan data ke dalam tabel contacts
        Contact::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
        ]);

        // Redirect kembali ke halaman kontak dengan pesan sukses
        return redirect()->route('contact.index')->with('success', 'Your message has been sent successfully!');
    }
}
