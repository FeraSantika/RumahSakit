<?php

namespace App\Exports;

use App\Models\Transaksi_barang_masuk;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class laporantransaksibmExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
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
        $query = Transaksi_barang_masuk::with('supplier');
        if ($this->tglAwal && $this->tglAkhir) {
            $query->whereBetween('tanggal_tbm', [$this->tglAwal, $this->tglAkhir]);
        }

        $data = $query->get();

        $grandtotal = $data->sum('harga_total');

        $formattedData = collect($data)->map(function ($item) {
            return [
                'No' => $this->serialNumber++,
                'Kode Transaksi' => $item->kode_transaksi,
                'Tanggal Transaksi' => $item->tanggal_tbm,
                'Nama Supplier' => optional($item->supplier)->nama_supplier ?? 'N/A',
                'Total Harga' => 'Rp' . '. ' . number_format($item->harga_total, 2, ',', '.'),
            ];
        });

        $formattedData->push([
            'No' => 'Grand Total',
            'Kode Transaksi' => '',
            'Tanggal Transaksi' => '',
            'Nama Supplier' => '',
            'Total Harga' => 'Rp' . '. ' . number_format($grandtotal, 2, ',', '.'),
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
                'Supplier',
                'Total'
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
            'A1:E1' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true],
            ],
            'A2:E2' =>[
                'alignment' => ['horizontal' => 'left'],
            ],
            'A3:E3' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true],
            ],
            'A1:E' . $lastRow => ['borders' => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]]],
            'A2:E' . $lastRow => ['borders' => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]]],
            'A3:E' . $lastRow => ['borders' => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]]],
        ];
    }

    public function title(): string
    {
        return 'Laporan_Transaksi_Barang_Masuk';
    }

    public function map($data): array
    {
        if ($data['Kode Transaksi'] === '' && $data['Tanggal Transaksi'] === '' && $data['Nama Supplier'] === '') {
            return [
                'No' => $data['No'],
                'Kode Transaksi' => $data['Kode Transaksi'],
                'Tanggal Transaksi' => $data['Tanggal Transaksi'],
                'Nama Supplier' => $data['Nama Supplier'],
                'Total Harga' => $data['Total Harga']
            ];
        } else {
            return [
                'No' => $data['No'],
                'Kode Transaksi' => $data['Kode Transaksi'],
                'Tanggal Transaksi' => $data['Tanggal Transaksi'],
                'Nama Supplier' => $data['Nama Supplier'],
                'Total Harga' => $data['Total Harga']
            ];
        }
    }
}
