<!DOCTYPE html>
<html>
<head>
    <title>Payment Report PDF</title>
    <style>
        body {
            font-family: 'Arial';
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: left;
        }
        td {
            padding: 10px;
            text-align: left;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .total-row {
            font-weight: bold;
            background-color: #ddd;
        }
        .total-row th, .total-row td {
            padding: 10px;
            text-align: right;
        }
    </style>
</head>
<body>
    <h1>Payment Report</h1>
    <table>
        <thead>
            <tr>
                <th>Receipt Code</th>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Payment Date</th>
                <th>Payment Method</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->order_id }}</td>
                    <td>{{ optional($payment->order->customer)->name ?? 'N/A' }}</td>
                    <td>{{ optional($payment->order->customer)->email ?? 'N/A' }}</td>
                    <td>{{ optional($payment->order->customer)->phone ?? 'N/A' }}</td>
                    <td>{{ $payment->payment_date }}</td>
                    <td>{{ $payment->payment_method }}</td>
                    <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="6" style="text-align: right;">Total</td>
                <td>Rp {{ number_format($totalAmount, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
