<?php

namespace App\Exports;

use App\Models\DataPoli;
use App\Models\RumahSakit;
use App\Models\PendaftaranPasien;
use App\Models\List_barang_keluar;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanpasienrawatjalanExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithMapping
{
    public $tglAwal;
    public $tglAkhir;
    public $status;
    public $poli;
    public $pemeriksaan;
    private $serialNumber;

    function __construct($tglAwal, $tglAkhir, $statusPasien, $pilihPoli, $pemeriksaan)
    {
        $this->tglAwal = $tglAwal;
        $this->tglAkhir = $tglAkhir;
        $this->status = $statusPasien;
        $this->poli = $pilihPoli;
        $this->pemeriksaan = $pemeriksaan;
        $this->serialNumber = 1;
    }

    public function collection()
    {
        $query = PendaftaranPasien::with('pasien', 'user', 'poli');

        if (!empty($this->tglAwal) && !empty($this->tglAkhir)) {
            $query->whereBetween('created_at', [$this->tglAwal, $this->tglAkhir]);
        }

        if (!empty($this->status)) {
            $query->where('status_pasien', $this->status);
        }

        if (!empty($this->poli)) {
            $query->where('id_poli', $this->poli);
        }

        if (!empty($this->pemeriksaan)) {
            $query->where('status_pemeriksaan', $this->pemeriksaan);
        }

        $data = $query->get();
        $formattedData = $data->map(function ($item) {
            $poli = $item->poli ? $item->poli->nama_poli : 'Poli Tidak Tersedia';
            return [
                'No' => $this->serialNumber++,
                'Tanggal' => \Carbon\Carbon::parse($item->created_at)->format('d/m/Y'),
                'Dokter' => $item->user ? $item->user->User_name : 'Dokter Tidak Tersedia',
                'Kode Pendaftaran' => $item->kode_pendaftaran,
                'Nama Pasien' => isset($item->pasien) ? $item->pasien->pasien_nama : '',
                'Status Pasien' => $item->status_pasien,
                'Poli' => $poli,
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
            ['Laporan Pendaftaran Pasien Rawat Jalan'],
            [],
        ];

        if ($this->tglAwal && $this->tglAkhir) {
            $filterText[] = ["Rentang Tanggal: {$this->tglAwal} hingga {$this->tglAkhir}"];
        }else {
            $filterText[] = ["Rentang Tanggal: Tanggal tidak diinputkan"];
        }

        if ($this->status) {
            $filterText[] =  ["Status Pasien: {$this->status}"];
        }else {
            $filterText[] = ["Status Pasien: Semua Pasien"];
        }

        if ($this->poli) {
            $filterText[] = ["Poli: {$this->getNamaPoli()}"];
        }else {
            $filterText[] = ["Poli: Semua Poli"];
        }

        if ($this->pemeriksaan) {
            $filterText[] = ["Status Pemeriksaan: {$this->pemeriksaan}"];
        }else {
            $filterText[] = ["Status Pemeriksaan: Semua Pemeriksaan"];
        }

        $filterText[] = [
            'No',
            'Tanggal',
            'Dokter',
            'Kode Pendaftaran',
            'Nama Pasien',
            'Status Pasien',
            'Poli',
            'Keluhan',
            'Status Pemeriksaan',
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
        $lastRow = count($this->collection()) + 10;
        $sheet->mergeCells('A1:I1');
        $sheet->mergeCells('A2:I2');
        $sheet->mergeCells('A4:I4');
        $sheet->mergeCells('A6:C6');
        $sheet->mergeCells('A7:C7');
        $sheet->mergeCells('A8:C8');
        $sheet->mergeCells('A9:C9');

        return [
            1 => [
                'font' => ['bold' => true, 'size' => 20],
            ],
            2 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
            ],
            'A1:I1' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true, 'size' => 20],
            ],
            'A2:I2' => [
                'font' => ['bold' => false],
            ],
            'A4:I4' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true],
            ],
            'A5:I5' => [
                'font' => ['bold' => false],
            ],
            'A6:I6' => [
                'font' => ['bold' => false],
            ],
            'A7:I7' => [
                'font' => ['bold' => false],
            ],
            'A8:I8' => [
                'font' => ['bold' => false],
            ],
            'A9:I9' => [
                'font' => ['bold' => false],
            ],
            'A10:I10' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true],
            ],
            'A10:I' . $lastRow => ['borders' => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]]],
        ];
    }

    public function title(): string
    {
        return 'Laporan_Pasien_Rawat_Jalan';
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
            'Poli' => $data['Poli'],
            'Keluhan' => $data['Keluhan'],
            'Status Pemeriksaan' => $data['Status Pemeriksaan'],
        ];
    }
}
