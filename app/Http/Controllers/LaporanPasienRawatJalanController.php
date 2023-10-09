<?php

namespace App\Http\Controllers;

use Log;
use Dompdf\Dompdf;
use App\Models\DataMenu;
use App\Models\DataPoli;
use App\Models\RumahSakit;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\PendaftaranPasien;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\laporanpasienrawatjalanExport;

class LaporanPasienRawatJalanController extends Controller
{
    public function index()
    {
        $dtpendaftar = PendaftaranPasien::with('pasien', 'poli', 'user')
            ->paginate(10);
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $poli = DataPoli::all();
        return view('laporanrawatjalan.laporanrawatjalan', compact('dtpendaftar', 'menu', 'roleuser', 'poli'));
    }

    public function getDataByDate(Request $request)
    {
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');
        $statusPasien = $request->input('statusPasien');
        $pilihPoli = $request->input('pilihPoli');
        $statusPemeriksaan = $request->input('statusPemeriksaan');

        $dataTerfilter = PendaftaranPasien::whereBetween('created_at', [$tglAwal, $tglAkhir])
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

        $dtpendaftar = PendaftaranPasien::whereBetween('created_at', [$tglAwal, $tglAkhir])
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

        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $namaPoli = DataPoli::where('id_poli', $pilihPoli)->value('nama_poli');

        $view = view('laporanrawatjalan.exportpdf', compact(
            'dtpendaftar',
            'tglAwal',
            'tglAkhir',
            'rs',
            'menu',
            'roleuser',
            'statusPasien',
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

        return $pdf->stream('Laporan_Pendaftaran_Pasien_Rawat_Jalan.pdf');
    }

    public function exportExcel(Request $request)
    {
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');
        $statusPasien = $request->input('statusPasien');
        $pilihPoli = $request->input('pilihPoli');
        $statusPemeriksaan = $request->input('statusPemeriksaan');

        $dtpendaftar = PendaftaranPasien::whereBetween('created_at', [$tglAwal, $tglAkhir])
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

        return Excel::download(new laporanpasienrawatjalanExport($tglAwal, $tglAkhir, $statusPasien, $pilihPoli, $statusPemeriksaan), 'Laporan_Pasien_Rawat_Jalan.xlsx');
    }
}
