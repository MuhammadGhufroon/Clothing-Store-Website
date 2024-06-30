<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $monthlyData = $this->getMonthlyData();
        return view('admin.dashboard.dashboard', compact('monthlyData'));
    }

    public function getMonthlyData()
{
    // Memeriksa apakah ada pesanan yang tersedia
    if(Order::exists()) {
        // Mengambil bulan pertama kali record disimpan
        $firstOrderDate = Order::orderBy('order_date', 'asc')->first()->order_date;
        $firstMonth = Carbon::parse($firstOrderDate)->startOfMonth();
        $currentMonth = Carbon::now()->startOfMonth();

        // Inisialisasi array untuk menyimpan data bulanan
        $monthlyData = [];

        // Loop dari bulan pertama hingga bulan saat ini
        while ($firstMonth <= $currentMonth) {
            $paidOrdersCount = Order::where('status', 'Paid')
                ->whereYear('order_date', $firstMonth->year)
                ->whereMonth('order_date', $firstMonth->month)
                ->count();

            $monthlyData[] = [
                'month' => $firstMonth->format('Y-m-d'), // Menyimpan tanggal lengkap
                'count' => $paidOrdersCount,
            ];

            // Pindah ke bulan berikutnya
            $firstMonth->addMonth();
        }

        return $monthlyData;
    } else {
        // Jika tidak ada pesanan, kembalikan array kosong
        return [];
    }
}


    // New API endpoint to return monthly data as JSON
    public function monthlyData()
    {
        $monthlyData = $this->getMonthlyData();
        return response()->json($monthlyData);
    }
}
