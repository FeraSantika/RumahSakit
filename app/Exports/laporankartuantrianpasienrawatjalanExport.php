<?php

namespace App\Exports;

use App\Models\DataPoli;
use App\Models\RumahSakit;
use App\Models\DataAntrian;
use App\Models\CetakDataAntrian;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporankartuantrianpasienrawatjalanExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithMapping
{
    public $tglAwal;
    public $tglAkhir;
    public $poli;
    private $serialNumber;

    function __construct($tglAwal, $tglAkhir, $pilihPoli)
    {
        $this->tglAwal = $tglAwal;
        $this->tglAkhir = $tglAkhir;
        $this->poli = $pilihPoli;
        $this->serialNumber = 1;
    }

    public function collection()
    {
        $query = CetakDataAntrian::with('poli')
            ->whereBetween('tanggal_antrian', [$this->tglAwal, $this->tglAkhir])
            ->when(!empty($this->poli), function ($query) {
                $query->where('id_poli', $this->poli);
            })->orderBy('tanggal_antrian');

        $result = $query->get();

        $formattedData = $result->map(function ($item) {
            return [
                'No' => $this->serialNumber++,
                'Tanggal' => $item->tanggal_antrian,
                'Poli' => $item->poli->nama_poli,
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
            ['Laporan Kartu Antrian Pasien Rawat Jalan'],
            [],
        ];

        if ($this->tglAwal && $this->tglAkhir) {
            $filterText[] = ["Rentang Tanggal: {$this->tglAwal} hingga {$this->tglAkhir}"];
        } else {
            $filterText[] = ["Rentang Tanggal: Tanggal tidak diinputkan"];
        }
        if ($this->poli) {
            $filterText[] = ["Poli: {$this->getNamaPoli()}"];
        } else {
            $filterText[] = ["Poli: Semua Poli"];
        }

        $filterText[] = [
            'No',
            'Tanggal',
            'Poli',
            'Jumlah Antrian',
        ];
        return $filterText;
    }

    private function getNamaPoli(): string
    {
        $idPoli = $this->poli;

        $namaPoli = DataPoli::where('id_poli', $idPoli)->value('nama_poli');

        return $namaPoli ?? '';
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = count($this->collection()) + 8;
        $sheet->mergeCells('A1:E1');
        $sheet->mergeCells('A2:E2');
        $sheet->mergeCells('A4:E4');
        $sheet->mergeCells('A6:E6');
        $sheet->mergeCells('A7:E7');

        return [
            1 => [
                'font' => ['bold' => true, 'size' => 20],
            ],
            2 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
            ],
            'A1:D1' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true, 'size' => 20],
            ],
            'A2:D2' => [
                'font' => ['bold' => false],
            ],
            'A4:D4' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true],
            ],
            'A5:D5' => [
                'font' => ['bold' => false],
            ],
            'A6:D6' => [
                'font' => ['bold' => false],
            ],
            'A7:D7' => [
                'font' => ['bold' => false],
            ],
            'A8:D8' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true],
            ],

            'A8:D' . $lastRow => ['borders' => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]]],
        ];
    }

    public function title(): string
    {
        return 'Laporan_Kartu_Antrian_Pasien_Rawat_Jalan';
    }

    public function map($data): array
    {
        return [
            'No' => $data['No'],
            'Tanggal' => $data['Tanggal'],
            'Poli' => $data['Poli'],
            'Jumlah Antrian' => $data['Jumlah Antrian'],
        ];
    }
}
