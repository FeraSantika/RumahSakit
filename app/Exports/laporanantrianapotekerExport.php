<?php

namespace App\Exports;

use App\Models\DataPoli;
use App\Models\RumahSakit;
use App\Models\ListDaftarObat;
use App\Models\DataAntrianObat;
use App\Models\PendaftaranPasien;
use App\Models\List_barang_keluar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanantrianapotekerExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithMapping
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
        $result = DataAntrianObat::whereBetween('tanggal_antrian', [$this->tglAwal, $this->tglAkhir])->get();;

        $formattedData = $result->map(function ($item) {
            return [
                'No' => $this->serialNumber++,
                'Tanggal' => $item->tanggal_antrian,
                'Jumlah Antrian' => $item->nomor_antrian,
            ];
        });

        return $formattedData;
    }

    public function headings(): array
    {
        $rs = RumahSakit::first();
        $hospitalName = $rs->nama_rumahsakit;
        $hospitalAddress = $rs->alamat_rumahsakit . ' || ' . $rs->telp_rumahsakit . ' ||  ' . $rs->email_rumahsakit;

        $filterText = [
            [$hospitalName],
            [$hospitalAddress],
            [],
            ['Laporan Antrian Apotek'],
            [],
        ];

        if ($this->tglAwal && $this->tglAkhir) {
            $filterText[] = ["Rentang Tanggal: {$this->tglAwal} hingga {$this->tglAkhir}"];
        }else {
            $filterText[] = ["Rentang Tanggal: Tanggal tidak diinputkan"];
        }

        $filterText[] = [
            'No',
            'Tanggal',
            'Jumlah Antrian',
        ];
        return $filterText;
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = count($this->collection()) + 7;
        $sheet->mergeCells('A1:E1');
        $sheet->mergeCells('A2:E2');
        $sheet->mergeCells('A4:E4');
        $sheet->mergeCells('A6:E6');

        return [
            1 => [
                'font' => ['bold' => true, 'size' => 20],
            ],
            2 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
            ],
            'A1:C1' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true, 'size' => 20],
            ],
            'A2:C2' => [
                'font' => ['bold' => false],
            ],
            'A4:C4' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true],
            ],
            'A5:C5' => [
                'font' => ['bold' => false],
            ],
            'A6:C6' => [
                'font' => ['bold' => false],
            ],
            'A7:C7' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true],
            ],

            'A7:C' . $lastRow => ['borders' => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]]],
        ];
    }

    public function title(): string
    {
        return 'Laporan_Antrian_Apotek';
    }

    public function map($data): array
    {
        return [
            'No' => $data['No'],
            'Tanggal' => $data['Tanggal'],
            'Jumlah Antrian' => $data['Jumlah Antrian'],
        ];
    }
}
