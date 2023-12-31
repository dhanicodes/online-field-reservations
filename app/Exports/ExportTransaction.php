<?php

namespace App\Exports;

use App\Models\Transaction;
use App\Models\FieldSchedule;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportTransaction implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    protected $statusAndDate;

    public function __construct($statusAndDate)
    {
        $this->statusAndDate = $statusAndDate;
    }

    /**
     * @return \Illuminate\Support\Collection
     */

    public function query()
    {
        $status = $this->statusAndDate['status'];
        $date = $this->statusAndDate['date'];
        // $data = Transaction::query()->where('status_pay_early', $this->statusAndDate);

        if ($status === 'selesai') {
            $data = Transaction::query()
                ->where('created_at', $date)
                ->where('status_pay_early', 'paid')
                ->orWhere('status_pay_final', 'paid');

            return $data;
        } else if ($status === 'belum-selesai') {
            $data = Transaction::query()
                ->where('created_at', $date)
                ->where('status_pay_early', 'unpaid')
                ->orWhere('status_pay_early', 'pending')
                ->orWhere('status_pay_final', 'pending')
                ->orWhere('status_pay_final', 'unpaid');

            return $data;
        } else if ($status === 'tidak-selesai') {
            $data = Transaction::query()
                ->where('created_at', $date)
                ->where('status_pay_early', 'expire')
                ->orWhere('status_pay_final', 'expire');

            return $data;
        } else if ($status) {
            $data = [];

            return $data;
        } else {
            if ($date) {
                $data = Transaction::query()->where('created_at', $date);
                return $data;
            } else {
                $data = Transaction::query();
                return $data;
            }
        }
    }

    public function map($transaksi): array
    {
        $idsubah = explode(',', $transaksi->schedule_ids);
        $belanja = FieldSchedule::whereIn('id', $idsubah)->get();

        $transactionDetails = [
            'First Name' => $transaksi->user->first_name,
            'Last Name' => $transaksi->user->last_name,
            'Team Name' => $transaksi->user->team_name,
            'Phone Number' => $transaksi->user->phone_number,
            'Email' => $transaksi->user->email,
            'Total Price' => $transaksi->total_price,
        ];

        $rows = [];

        if ($belanja->count() > 1) {
            foreach ($belanja as $key => $item) {
                if ($key === 0) {
                    $row = array_merge($transactionDetails, [
                        'Field Name' => $item->fieldList->name,
                        'Date' => $item->date,
                        'Time Start' => $item->time_start,
                        'Time Finish' => $item->time_finish,
                        'Price' => $item->price,
                    ]);
                } else {
                    $row = [
                        'First Name' => '',
                        'Last Name' => '',
                        'Team Name' => '',
                        'Phone Number' => '',
                        'Email' => '',
                        'Total Price' => '',
                        'Field Name' => $item->fieldList->name,
                        'Date' => $item->date,
                        'Time Start' => $item->time_start,
                        'Time Finish' => $item->time_finish,
                        'Price' => $item->price,
                    ];
                }
                $rows[] = $row;
            }
        } else {
            $row = array_merge($transactionDetails, [
                'Field Name' => $belanja->first()->fieldList->name,
                'Date' => $belanja->first()->date,
                'Time Start' => $belanja->first()->time_start,
                'Time Finish' => $belanja->first()->time_finish,
                'Price' => $belanja->first()->price,
            ]);
            $rows[] = $row;
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Nama Depan',
            'Nama Belakang',
            'Nama Tim',
            'Nomor Telpon',
            'Email',
            'Total Harga',
            'Nama Lapangan',
            'Tanggal',
            'Jam Mulai',
            'Jam Selesai',
            'Harga',
        ];
    }
}
