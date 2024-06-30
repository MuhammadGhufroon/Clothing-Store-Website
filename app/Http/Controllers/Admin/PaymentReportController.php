<?php


// app/Http/Controllers/Admin/PaymentReportController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PaymentExport;
use PDF;

class PaymentReportController extends Controller
{
    public function index()
    {
        $payments = Payment::with('order.customer')->get();
        $totalAmount = $payments->sum('amount');
        return view('admin.payment-report.payment-report', compact('payments', 'totalAmount'));
    }

    public function exportPdf()
    {
        $payments = Payment::with('order.customer')->get();
        $totalAmount = $payments->sum('amount');
        $pdf = PDF::loadView('admin.payment-report.payment-reportPDF', compact('payments', 'totalAmount'));
        return $pdf->download('payment-report.pdf');
    }

    public function exportExcel()
    {
        $payments = Payment::with('order.customer')->get();
        return Excel::download(new PaymentExport($payments), 'payment-report.xlsx');
    }
}


