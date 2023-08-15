<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use App\Models\Transaksi_barang_keluar;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class laporantransaksibkExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public $tglAwal;
    public $tglAkhir;
    private $serialNumber;

    function __construct($tglAwal, $tglAkhir)
    {
        $this->tglAwal = $tglAwal;
        $this->tglAkhir = $tglAkhir;
        $this->serialNumber = 1;
    }

    public function collection()
    {
        $query = Transaksi_barang_keluar::with('user');
        if ($this->tglAwal && $this->tglAkhir) {
            $query->whereBetween('tanggal_tbk', [$this->tglAwal, $this->tglAkhir]);
        }

        $data = $query->get();

        $totaTotalbayar = $data->sum('total_bayar');
        $totalDibayar = $data->sum('dibayar');
        $totalKembalian = $data->sum('kembalian');

        $formattedData = collect($data)->map(function ($item) {
            return [
                'No' => $this->serialNumber++,
                'Kode Transaksi' => $item->kode_transaksi,
                'Tanggal Transaksi' => $item->tanggal_tbk,
                'Kasir' => optional($item->user)->User_name ?? 'N/A',
                'Nama Customer' => $item->customer,
                'Diskon' => $item->diskon_tbk,
                'Total Bayar' => 'Rp' . '. ' . number_format($item->total_bayar, 2, ',', '.'),
                'Dibayar' => 'Rp' . '. ' . number_format($item->dibayar, 2, ',', '.'),
                'Kembalian' => 'Rp' . '. ' . number_format($item->kembalian, 2, ',', '.'),
            ];
        });

        $formattedData->push([
            'No' => 'Grand Total',
            'Kode Transaksi' =>  '',
            'Tanggal Transaksi' => '',
            'Kasir' => '',
            'Nama Customer' => '',
            'Diskon' => '',
            'Total Bayar' => 'Rp' . '. ' . number_format($totaTotalbayar, 2, ',', '.'),
            'Dibayar' => 'Rp' . '. ' . number_format($totalDibayar, 2, ',', '.'),
            'Kembalian' => 'Rp' . '. ' . number_format($totalKembalian, 2, ',', '.'),
        ]);

        return $formattedData;
    }

    public function headings(): array
    {
        $dateRangeText = $this->tglAwal && $this->tglAkhir
            ? "Rentang Tanggal : {$this->tglAwal} hingga {$this->tglAkhir}"
            : '';

        return [
            ['Laporan Transaksi Barang Keluar'],
            [$dateRangeText],
            [
                'No',
                'Kode Transaksi',
                'Tanggal',
                'Nama Kasir',
                'Customer',
                'Diskon',
                'Jumlah Bayar',
                'Dibayar',
                'Kembalian',
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = count($this->collection()) + 3; // Ditambah 3 untuk baris tambahan

        return [
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
                'borders' => ['outline' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]],
            ],
            'A1:I1' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true],
            ],
            'A2:I2' => [
                'alignment' => ['horizontal' => 'left'],
            ],
            'A3:I3' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true],
            ],
            'A1:I' . $lastRow => ['borders' => ['allBorders' => ['borderStyle' => 'tIin', 'color' => ['rgb' => '000000']]]],
            'A2:I' . $lastRow => ['borders' => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]]],
            'A3:I' . $lastRow => ['borders' => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]]],
        ];
    }

    public function title(): string
    {
        return 'Laporan_Transaksi_Barang_Keluar';
    }

    public function map($data): array
    {
        if ($data['Kode Transaksi'] === '' && $data['Tanggal Transaksi'] === '' && $data['Kasir'] === '') {
            return [
                'No' => $data['No'],
                'Kode Transaksi' => $data['Kode Transaksi'],
                'Tanggal Transaksi' => $data['Tanggal Transaksi'],
                'Kasir' => $data['Kasir'],
                'Customer' => $data['Nama Customer'],
                'Diskon' => $data['Diskon'],
                'Jumlah Bayar' => $data['Total Bayar'],
                'Dibayar' => $data['Dibayar'],
                'Kembalian' => $data['Kembalian'],
            ];
        } else {
            return [
                'No' => $data['No'],
                'Kode Transaksi' => $data['Kode Transaksi'],
                'Tanggal Transaksi' => $data['Tanggal Transaksi'],
                'Kasir' => $data['Kasir'],
                'Customer' => $data['Nama Customer'],
                'Diskon' => $data['Diskon'],
                'Jumlah Bayar' => $data['Total Bayar'],
                'Dibayar' => $data['Dibayar'],
                'Kembalian' => $data['Kembalian'],
            ];
        }
    }
}
