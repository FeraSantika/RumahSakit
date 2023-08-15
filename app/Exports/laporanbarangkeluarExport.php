<?php

namespace App\Exports;

use App\Models\List_barang_keluar;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanBarangKeluarExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithMapping
{
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
        $query = List_barang_keluar::leftJoin('transaksi_barang_keluar', 'transaksi_barang_keluar.kode_transaksi', '=', 'list_barang_keluar.kode_transaksi')
            ->selectRaw('list_barang_keluar.*, sum(list_barang_keluar.jumlah_bk) as jumlahbk')
            ->groupBy('list_barang_keluar.kode_barang')
            ->with('barang', 'barang.kategori');

        if ($this->tglAwal && $this->tglAkhir) {
            $query->whereBetween('tanggal_tbk', [$this->tglAwal, $this->tglAkhir]);
        }

        $data = $query->get();

        $totalJumlahTerjual = $data->sum('jumlahbk');

        $formattedData = $data->map(function ($item) {
            $barangNames = $item->barang->map(function ($barang) {
                return optional($barang)->nama_barang ?? 'N/A';
            })->implode(', ');

            $kategoriNames = $item->barang->map(function ($barang) {
                return optional($barang->kategori)->nama_kategori ?? 'N/A';
            })->implode(', ');

            return [
                'No' => $this->serialNumber++,
                'Nama Barang' => $barangNames,
                'Nama Kategori' => $kategoriNames,
                'Terjual' => $item->jumlahbk,
            ];
        });

        $formattedData->push([
            'No' => 'Grand Total',
            'Nama Barang' =>  '',
            'Nama Kategori' => '',
            'Terjual' => $totalJumlahTerjual,
        ]);

        return $formattedData;
    }

    public function headings(): array
    {
        $dateRangeText = $this->tglAwal && $this->tglAkhir
            ? "Rentang Tanggal : {$this->tglAwal} hingga {$this->tglAkhir}"
            : '';

        return [
            ['Laporan Barang Keluar'],
            [$dateRangeText],
            [
                'No',
                'Nama Barang',
                'Nama Kategori',
                'Terjual'
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
            ],
            'A1:D1' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true],
            ],
            'A2:D2' => [
                'alignment' => ['horizontal' => 'left'],
            ],
            'A3:D3' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true],
            ],
            'A1:D' . $lastRow => ['borders' => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]]],
            'A2:D' . $lastRow => ['borders' => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]]],
            'A3:D' . $lastRow => ['borders' => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]]],
        ];
    }

    public function title(): string
    {
        return 'Laporan_Barang_Keluar';
    }

    public function map($data): array
    {
        return [
            'No' => $data['No'],
            'Nama Barang' => $data['Nama Barang'],
            'Nama Kategori' => $data['Nama Kategori'],
            'Terjual' => $data['Terjual'],
        ];
    }
}
