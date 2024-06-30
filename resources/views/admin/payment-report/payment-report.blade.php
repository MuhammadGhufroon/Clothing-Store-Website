@extends('admin.dashboard.main')
@section('title', 'Payment-Report')
@section('sidenav')
    @include('admin.dashboard.sidenav')
@endsection
@section('page', 'Payment-Report')
@section('nav')
    @include('admin.dashboard.nav')

<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Payment Report</h1>
            <a href="{{ route('payment.report.pdf') }}" class="btn btn-primary mb-3">Download PDF</a>
            <a href="{{ route('payment.report.excel') }}" class="btn btn-success mb-3">Export to Excel</a>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">Receipt Code</th>
                        <th class="text-center">Customer Name</th>
                        <th class="text-center">Customer Email</th>
                        <th class="text-center">Customer Phone</th>
                        <th class="text-center">Payment Date</th>
                        <th class="text-center">Payment Method</th>
                        <th class="text-center">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                        <tr>
                            <td class="text-center">{{ $payment->order_id }}</td>
                            <td class="text-center">{{ optional($payment->order->customer)->name ?? 'N/A' }}</td> <!-- Display customer name -->
                            <td class="text-center">{{ optional($payment->order->customer)->email ?? 'N/A' }}</td> <!-- Display customer name -->
                            <td class="text-center">{{ optional($payment->order->customer)->phone ?? 'N/A' }}</td> <!-- Display customer name -->
                            <td class="text-center">{{ $payment->payment_date }}</td>
                            <td class="text-center">{{ $payment->payment_method }}</td>
                            <td class="text-center">{{ 'Rp ' . number_format($payment->amount, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="6" class="text-right">Total:</th>
                        <th class="text-center">{{ 'Rp ' . number_format($totalAmount, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
