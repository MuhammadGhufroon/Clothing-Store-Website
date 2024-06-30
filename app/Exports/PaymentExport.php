<?php

namespace App\Exports;

use App\Models\Payment;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class PaymentExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithMapping
{
    protected $payments;

    public function __construct(Collection $payments)
    {
        $this->payments = $payments;
    }

    public function collection()
    {
        // Hitung total jumlah dari semua nilai di kolom Amount (RP)
        $totalAmount = $this->payments->sum('amount');

        return $this->payments->map(function ($payment) {
            return [
                $payment->id,
                $payment->order_id,
                optional($payment->order->customer)->name ?? 'N/A', // Customer Name
                optional($payment->order->customer)->email ?? 'N/A', // Customer Email
                optional($payment->order->customer)->phone ?? 'N/A', // Customer Phone
                optional($payment->order->customer)->address1 ?? 'N/A', // Customer Address1
                optional($payment->order->customer)->address2 ?? 'N/A', // Customer Address2
                optional($payment->order->customer)->address3 ?? 'N/A', // Customer Address3
                Carbon::parse($payment->payment_date)->format('Y-m-d H:i:s'),
                $payment->payment_method,
                $payment->amount,
            ];
        })
        ->push(['', '', '', '', '', '', '', '', 'Total Amount', $totalAmount]); // Tambahkan baris total di akhir
    }

    public function map($row): array
{
    return [
        $row[0],
        $row[1],
        $row[2],
        $row[3],
        $row[4],
        $row[5],
        $row[6],
        $row[7],
        $row[8],
        'Rp ' . number_format(floatval($row[9]), 0, ',', '.') // Mengubah nilai $row[9] menjadi float
    ];
}


    public function headings(): array
    {
        return [
            'ID',
            'Receipt Code',
            'Customer Name',
            'Customer Email',
            'Customer Phone',
            'Customer Address1',
            'Customer Address2',
            'Customer Address3',
            'Payment Date',
            'Payment Method',
            'Amount (Rp)',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Gaya untuk header
        $sheet->getStyle('A1:K1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4CAF50'],
            ],
        ]);

        // Gaya untuk baris total
        $totalRow = $this->payments->count() + 2; // Baris total adalah setelah data ditambah header
        $sheet->getStyle('A' . $totalRow . ':K' . $totalRow)->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'DDDDDD'],
            ],
        ]);

        // Gaya untuk baris data bergantian
        foreach ($this->payments as $index => $payment) {
            $row = $index + 2; // Karena baris pertama adalah header
            if ($index % 2 == 0) {
                $sheet->getStyle('A' . $row . ':K' . $row)->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'F2F2F2'],
                    ],
                ]);
            }
        }
    }
}
