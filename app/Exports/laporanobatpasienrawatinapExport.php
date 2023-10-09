<?php

namespace App\Exports;

use App\Models\RumahSakit;
use App\Models\PendaftaranPasien;
use App\Models\List_barang_keluar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\ListDaftarObatPasienInap;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanobatpasienrawatinapExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithMapping
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
        $query = DB::table('list_daftar_obat_pasieninap')
            ->join('pendaftaran_pasien_inap', 'list_daftar_obat_pasieninap.kode_pendaftaran', '=', 'pendaftaran_pasien_inap.kode_pendaftaran')
            ->select('list_daftar_obat_pasieninap.nama_obat', DB::raw('SUM(list_daftar_obat_pasieninap.qty) as total_qty'))
            ->whereBetween('list_daftar_obat_pasieninap.tanggal', [$this->tglAwal, $this->tglAkhir]);

        if (!empty($this->status)) {
            $query->where('pendaftaran_pasien_inap.status_pasien', $this->status);
        }

        if (!empty($this->pemeriksaan)) {
            $query->where('pendaftaran_pasien_inap.status_pemeriksaan', $this->pemeriksaan);
        }

        $query->groupBy('list_daftar_obat_pasieninap.nama_obat');
        $results = $query->get();

        $formattedData = $results->map(function ($item) {
            return [
                'No' => $this->serialNumber++,
                'Nama Obat' => $item->nama_obat,
                'Jumlah Terjual' => $item->total_qty,
            ];
        });

        return $formattedData;
    }

    public function headings(): array
    {
        $rs = RumahSakit::first();
        $hospitalName = $rs->nama_rumahsakit;
        $hospitalAddress = $rs->alamat_rumahsakit . ' || ' . $rs->telp_rumahsakit . ' ||  ' . $rs->email_rumahsakit;

        $reportData = [
            [$hospitalName],
            [$hospitalAddress],
            [],
            ['Laporan Obat Pasien Rawat Inap'],
            [],
        ];

        if ($this->tglAwal && $this->tglAkhir) {
            $reportData[] = ["Rentang Tanggal: {$this->tglAwal} hingga {$this->tglAkhir}"];
        } else {
            $reportData[] = ["Rentang Tanggal: Tanggal tidak diinputkan"];
        }

        if ($this->status) {
            $reportData[] = ["Status Pasien: {$this->status}"];
        } else {
            $reportData[] = ["Status Pasien: Semua Pasien"];
        }

        if ($this->pemeriksaan) {
            $reportData[] = ["Status Pemeriksaan: {$this->pemeriksaan}"];
        } else {
            $reportData[] = ["Status Pemeriksaan: Semua pemeriksaan"];
        }

        $reportData[] =
            [
                'No',
                'Nama Obat',
                'Jumlah Terjual',
            ];

        return $reportData;
    }


    public function styles(Worksheet $sheet)
    {
        $lastRow = count($this->collection()) + 9;
        $sheet->mergeCells('A1:C1');
        $sheet->mergeCells('A2:C2');
        $sheet->mergeCells('A4:C4');
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
                'font' => ['bold' => false],
            ],
            'A8:C8' => [
                'font' => ['bold' => false],
            ],
            'A9:C9' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true],
            ],

            'A9:C' . $lastRow => ['borders' => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]]],
        ];
    }

    public function title(): string
    {
        return 'Laporan_Obat_Pasien_Rawat_Inap';
    }

    public function map($data): array
    {
        return [
            'No' => $data['No'],
            'Nama Obat' => $data['Nama Obat'],
            'Jumlah Terjual' => $data['Jumlah Terjual'],
        ];
    }
}
