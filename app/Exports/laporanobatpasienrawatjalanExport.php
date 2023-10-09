<?php

namespace App\Exports;

use App\Models\DataPoli;
use App\Models\RumahSakit;
use App\Models\ListDaftarObat;
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

class LaporanobatpasienrawatjalanExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithMapping
{
    public $tglAwal;
    public $tglAkhir;
    public $status;
    public $poli;
    public $pemeriksaan;
    private $serialNumber;

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
        $query = DB::table('list_daftar_obat_pasien')
            ->join('pendaftaran_pasien', 'list_daftar_obat_pasien.kode_pendaftaran', '=', 'pendaftaran_pasien.kode_pendaftaran')
            ->select('pendaftaran_pasien.*', 'list_daftar_obat_pasien.nama_obat', DB::raw('SUM(list_daftar_obat_pasien.qty) as total_qty'))
            ->whereBetween('list_daftar_obat_pasien.created_at', [$this->tglAwal, $this->tglAkhir]);
        if (!empty($this->status)) {
            $query->where('pendaftaran_pasien.status_pasien', $this->status);
        }
        if (!empty($this->poli)) {
            $query->where('pendaftaran_pasien.id_poli', $this->poli);
        }
        if (!empty($this->pemeriksaan)) {
            $query->where('pendaftaran_pasien.status_pemeriksaan', $this->pemeriksaan);
        }

        $query->groupBy('list_daftar_obat_pasien.nama_obat');
        $result = $query->get();

        $formattedData = $result->map(function ($item) {
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

        $filterText = [
            [$hospitalName],
            [$hospitalAddress],
            [],
            ['Laporan Obat Pasien Rawat Jalan'],
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
            'Nama Obat',
            'Jumlah Terjual',
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
        $sheet->mergeCells('A1:C1');
        $sheet->mergeCells('A2:C2');
        $sheet->mergeCells('A4:C4');
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
                'font' => ['bold' => false],
            ],
            'A10:C10' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true],
            ],

            'A10:C' . $lastRow => ['borders' => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]]],
        ];
    }

    public function title(): string
    {
        return 'Laporan_Obat_Pasien_Rawat_Jalan';
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
