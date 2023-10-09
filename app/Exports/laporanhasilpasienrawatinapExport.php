<?php

namespace App\Exports;

use App\Models\RumahSakit;
use App\Models\List_barang_masuk;
use App\Models\PendaftaranPasienInap;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class laporanhasilpasienrawatinapExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithMapping, WithEvents
{
    public $tglAwal;
    public $tglAkhir;
    public $status;
    public $pemeriksaan;
    private $serialNumber;
    private $totalGrandtotal = 0;
    private $totalRows = 0;

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
        $query = PendaftaranPasienInap::where('grandtotal', '!=', 0)->with('pasien', 'user');
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
            ['Laporan Hasil Pasien Rawat Inap '],
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
                'Total Pembayaran',
            ];

        return $filterText;
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
                        'Rp ' . number_format($this->totalGrandtotal, 0, ',', '.'),
                    ],
                ]);
                $grandtotalRow = $this->totalRows + 3;

                $event->sheet->getStyle('A' . ($this->totalRows + 10) . ':I' . ($this->totalRows + 10))->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => 'left'],
                    'borders' => ['outline' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]]
                ]);
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = count($this->collection()) + 9;
        $sheet->mergeCells('A1:I1');
        $sheet->mergeCells('A2:I2');
        $sheet->mergeCells('A4:I4');
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
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true],
            ],
            'A9:I' . $lastRow => ['borders' => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]]],
        ];
    }

    public function title(): string
    {
        return 'Laporan_Hasil_Pasien_Rawat_Inap';
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
            'Keluhan' => $data['Keluhan'],
            'Status Pemeriksaan' => $data['Status Pemeriksaan'],
            'Total Pembayaran' => $data['Total Pembayaran'],
        ];
    }
}
