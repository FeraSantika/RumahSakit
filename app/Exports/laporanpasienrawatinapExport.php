<?php

namespace App\Exports;

use App\Models\RumahSakit;
use App\Models\List_barang_masuk;
use App\Models\PendaftaranPasienInap;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class laporanpasienrawatinapExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithMapping
{
    public $tglAwal;
    public $tglAkhir;
    public $status;
    public $pemeriksaan;
    private $serialNumber;

    function __construct($tglAwal, $tglAkhir, $status, $pemeriksaan)
    {
        $this->tglAwal = $tglAwal;
        $this->tglAkhir = $tglAkhir;
        $this->status = $status;
        $this->pemeriksaan = $pemeriksaan;
        $this->serialNumber = 1;
    }

    public function collection()
    {
        $query = PendaftaranPasienInap::with('pasien', 'user');
        if (!empty($this->tglAwal) && !empty($this->tglAkhir)) {
            $query->whereBetween('created_at', [$this->tglAwal, $this->tglAkhir]);
        }

        if (!empty($this->status)) {
            $query->where('status_pasien', $this->status);
        }

        if (!empty($this->pemeriksaan)) {
            $query->where('status_pemeriksaan', $this->pemeriksaan);
        }
        $data = $query->get();

        $formattedData = $data->map(function ($item) {

            return [
                'No' => $this->serialNumber++,
                'Tanggal' => \Carbon\Carbon::parse($item->created_at)->format('d/m/Y'),
                'Dokter' => $item->user ? $item->user->User_name : 'Dokter Tidak Tersedia',
                'Kode Pendaftaran' => $item->kode_pendaftaran,
                'Nama Pasien' => isset($item->pasien) ? $item->pasien->pasien_nama : '',
                'Status Pasien' => $item->status_pasien,
                'Keluhan' => $item->keluhan,
                'Status Pemeriksaan' => $item->status_pemeriksaan,
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
            ['Laporan Pendaftaran Pasien Rawat Inap '],
            [],
        ];

        if ($this->tglAwal && $this->tglAkhir) {
            $filterText[] = ["Rentang Tanggal: {$this->tglAwal} hingga {$this->tglAkhir}"];
        } else {
            $filterText[] = ["Rentang Tanggal: Tanggal tidak diinputkan"];
        }

        if ($this->status) {
            $filterText[] = ["Status Pasien: {$this->status}"];
        } else {
            $filterText[] = ["Status Pasien: Semua Pasien"];
        }

        if ($this->pemeriksaan) {
            $filterText[] = ["Status Pemeriksaan: {$this->pemeriksaan}"];
        } else {
            $filterText[] = ["Status Pemeriksaan: Semua pemeriksaan"];
        }

        $filterText[] =
            [
                'No',
                'Tanggal',
                'Dokter',
                'Kode Pendaftaran',
                'Nama Pasien',
                'Status Pasien',
                'Keluhan',
                'Status Pemeriksaan',
            ];

        return $filterText;
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = count($this->collection()) + 9;
        $sheet->mergeCells('A1:H1');
        $sheet->mergeCells('A2:H2');
        $sheet->mergeCells('A4:H4');
        $sheet->mergeCells('A6:C6');
        $sheet->mergeCells('A7:C7');
        $sheet->mergeCells('A8:C8');

        return [
            1 => [
                'font' => ['bold' => true, 'size' => 20],
            ],
            2 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
            ],
            'A1:H1' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true, 'size' => 20],
            ],
            'A2:H2' => [
                'font' => ['bold' => false],
            ],
            'A4:H4' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true],
            ],
            'A5:H5' => [
                'font' => ['bold' => false],
            ],
            'A6:H6' => [
                'font' => ['bold' => false],
            ],
            'A7:H7' => [
                'font' => ['bold' => false],
            ],
            'A8:H8' => [
                'font' => ['bold' => false],
            ],
            'A9:H9' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true],
            ],
            'A9:H' . $lastRow => ['borders' => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]]],
        ];
    }

    public function title(): string
    {
        return 'Laporan_Pasien_Rawat_Inap';
    }

    public function map($data): array
    {
        return [
            'No' => $data['No'],
            'Tanggal' => $data['Tanggal'],
            'Dokter' => $data['Dokter'],
            'Kode Pendaftaran' => $data['Kode Pendaftaran'],
            'Nama Pasien' => $data['Nama Pasien'],
            'Status Pasien' => $data['Status Pasien'],
            'Keluhan' => $data['Keluhan'],
            'Status Pemeriksaan' => $data['Status Pemeriksaan'],
        ];
    }
}
