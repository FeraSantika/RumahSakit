<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\DataMenu;
use App\Models\DataPoli;
use App\Models\RumahSakit;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\PendaftaranPasien;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\laporanhasilpasienrawatjalanExport;

class LaporanHasilRawatJalanController extends Controller
{
    public function index()
    {
        $dtpendaftar = PendaftaranPasien::where('grandtotal', '!=', 0)->orderBy('id_pendaftaran', 'desc')->with('pasien', 'poli', 'user')
            ->paginate(10);
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $poli = DataPoli::all();
        return view('laporanhasilrawatjalan.laporanhasilrawatjalan', compact('dtpendaftar', 'menu', 'roleuser', 'poli'));
    }

    public function getDataByDate(Request $request)
    {
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');
        $statusPasien = $request->input('statusPasien');
        $pilihPoli = $request->input('pilihPoli');
        $statusPemeriksaan = $request->input('statusPemeriksaan');

        $dataTerfilter = PendaftaranPasien::where('grandtotal', '!=', 0)->whereBetween('created_at', [$tglAwal, $tglAkhir])
            ->when(!empty($statusPasien), function ($query) use ($statusPasien) {
                $query->where('status_pasien', $statusPasien);
            })
            ->when(!empty($pilihPoli), function ($query) use ($pilihPoli) {
                $query->where('id_poli', $pilihPoli);
            })
            ->when(!empty($statusPemeriksaan), function ($query) use ($statusPemeriksaan) {
                $query->where('status_pemeriksaan', $statusPemeriksaan);
            })
            ->with('pasien', 'poli', 'user')
            ->get();
        return response()->json($dataTerfilter);
    }

    public function exportPDF(Request $request)
    {
        $rs = RumahSakit::first();
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');
        $statusPasien = $request->input('statusPasien');
        $pilihPoli = $request->input('pilihPoli');
        $statusPemeriksaan = $request->input('statusPemeriksaan');

        // $query = PendaftaranPasien::query();

        // if (!empty($statusPasien)) {
        //     $query->where('status_pasien', $statusPasien);
        // }

        // if ($tglAwal && $tglAkhir) {
        //     $query->whereBetween('created_at', [$tglAwal, $tglAkhir]);
        // }

        // $dtpendaftar = $query->where('grandtotal', '!=', 0)->with('pasien', 'poli', 'user')->get();

        $dtpendaftar = PendaftaranPasien::whereBetween('created_at', [$tglAwal, $tglAkhir])->where('grandtotal', '!=', 0)
            ->when(!empty($statusPasien), function ($query) use ($statusPasien) {
                $query->where('status_pasien', $statusPasien);
            })
            ->when(!empty($pilihPoli), function ($query) use ($pilihPoli) {
                $query->where('id_poli', $pilihPoli);
            })
            ->when(!empty($statusPemeriksaan), function ($query) use ($statusPemeriksaan) {
                $query->where('status_pemeriksaan', $statusPemeriksaan);
            })
            ->with('pasien', 'poli', 'user')
            ->get();

        $namaPoli = DataPoli::where('id_poli', $pilihPoli)->value('nama_poli');
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $view = view('laporanhasilrawatjalan.exportpdf', compact(
            'dtpendaftar',
            'tglAwal',
            'tglAkhir',
            'rs',
            'statusPasien',
            'menu',
            'roleuser',
            'statusPemeriksaan',
            'namaPoli'
        ))->render();

        $pdf = new Dompdf();
        $pdf->loadHtml($view);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        $pdfContent = $pdf->output();

        $pdfFilePath = 'path_to_save.pdf';
        \Illuminate\Support\Facades\Storage::put($pdfFilePath, $pdfContent);

        return $pdf->stream('Laporan_Hasil_Pasien_Rawat_Jalan.pdf');
    }

    public function exportExcel(Request $request)
    {
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');
        $statusPasien = $request->input('statusPasien');
        $pilihPoli = $request->input('pilihPoli');
        $statusPemeriksaan = $request->input('statusPemeriksaan');

        $dtpendaftar = PendaftaranPasien::whereBetween('created_at', [$tglAwal, $tglAkhir])->where('grandtotal', '!=', 0)
            ->when(!empty($statusPasien), function ($query) use ($statusPasien) {
                $query->where('status_pasien', $statusPasien);
            })
            ->when(!empty($pilihPoli), function ($query) use ($pilihPoli) {
                $query->where('id_poli', $pilihPoli);
            })
            ->when(!empty($statusPemeriksaan), function ($query) use ($statusPemeriksaan) {
                $query->where('status_pemeriksaan', $statusPemeriksaan);
            })
            ->with('pasien', 'poli', 'user')
            ->get();

        return Excel::download(new laporanhasilpasienrawatjalanExport($tglAwal, $tglAkhir, $statusPasien, $pilihPoli, $statusPemeriksaan), 'Laporan_Hasil_Pasien_Rawat_Jalan.xlsx');
    }
}
