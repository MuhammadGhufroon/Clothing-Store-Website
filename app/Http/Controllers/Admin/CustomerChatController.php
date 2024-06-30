<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact; // Pastikan untuk mengimpor model Contact jika belum

class CustomerChatController extends Controller
{
    public function index()
    {
        // Misalnya, Anda ingin mengambil semua data dari model Contact
        $customerChats = Contact::all(); // Ini adalah contoh, Anda mungkin ingin melakukan query yang lebih spesifik
        
        return view('admin.customer-chat.index', compact('customerChats'));
    }
}

