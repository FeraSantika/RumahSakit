<?php

namespace App\Exports;

use App\Models\DataPoli;
use App\Models\RumahSakit;
use App\Models\PendaftaranPasien;
use App\Models\List_barang_keluar;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanhasilpasienrawatjalanExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithMapping, WithEvents
{
    public $tglAwal;
    public $tglAkhir;
    public $status;
    public $poli;
    public $pemeriksaan;
    private $serialNumber;
    private $totalGrandtotal = 0;
    private $totalRows = 0;

    function __construct($tglAwal, $tglAkhir, $status, $pilihPoli, $pemeriksaan)
    {
        $this->tglAwal = $tglAwal;
        $this->tglAkhir = $tglAkhir;
        $this->status = $status;
        $this->poli = $pilihPoli;
        $this->pemeriksaan = $pemeriksaan;
        $this->serialNumber = 1;
    }

    public function collection()
    {
        $query = PendaftaranPasien::where('grandtotal', '!=', 0)->with('pasien', 'user', 'poli');

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
                'Total Pembayaran' => 'Rp ' . number_format($item->grandtotal, 0, ',', '.'),
            ];
        });

        $this->totalRows = count($formattedData);
        $this->totalGrandtotal = $data->sum('grandtotal');
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
            ['Laporan Hasil Pasien Rawat Jalan'],
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

        if ($this->poli) {
            $filterText[] = ["Poli: {$this->getNamaPoli()}"];
        } else {
            $filterText[] = ["Poli: Semua Poli"];
        }

        if ($this->pemeriksaan) {
            $filterText[] = ["Status Pemeriksaan: {$this->pemeriksaan}"];
        } else {
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
            'Total Pembayaran',
        ];
        return $filterText;
    }

    private function getNamaPoli(): string
    {
        $idPoli = $this->poli;

        $namaPoli = DataPoli::where('id_poli', $idPoli)->value('nama_poli');

        return $namaPoli ?? '';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:J1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 20],
                    'alignment' => ['horizontal' => 'center'],
                ]);

                $event->sheet->append([
                    [
                        'Grandtotal : ',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        'Rp ' . number_format($this->totalGrandtotal, 0, ',', '.'),
                    ],
                ]);
                $grandtotalRow = $this->totalRows + 3;

                $event->sheet->getStyle('A' . ($this->totalRows + 11) . ':J' . ($this->totalRows + 11))->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => 'left'],
                    'borders' => ['outline' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]]
                ]);
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = count($this->collection()) + 10;
        $sheet->mergeCells('A1:J1');
        $sheet->mergeCells('A2:J2');
        $sheet->mergeCells('A4:J4');
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
            'A1:J1' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true, 'size' => 20],
            ],
            'A2:J2' => [
                'font' => ['bold' => false],
            ],
            'A4:J4' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true],
            ],
            'A5:J5' => [
                'font' => ['bold' => false],
            ],
            'A6:J6' => [
                'font' => ['bold' => false],
            ],
            'A7:J7' => [
                'font' => ['bold' => false],
            ],
            'A8:J8' => [
                'font' => ['bold' => false],
            ],
            'A9:J9' => [
                'font' => ['bold' => false],
            ],
            'A10:J10' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true],
            ],
            'A10:J' . $lastRow => ['borders' => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]]],
        ];
    }

    public function title(): string
    {
        return 'Laporan_Hasil_Pasien_Rawat_Jalan';
    }

    public function map($data): array
    {
        $totalPembayaran = str_replace(['.', ','], '', $data['Total Pembayaran']);
        $totalPembayaran = (int) $totalPembayaran;

        $this->totalGrandtotal += $totalPembayaran;

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
            'Total Pembayaran' => $data['Total Pembayaran'],
        ];
    }
}
