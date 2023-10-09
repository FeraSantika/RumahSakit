<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\DataMenu;
use App\Models\RumahSakit;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PendaftaranPasienInap;
use App\Exports\laporanhasilpasienrawatinapExport;

class LaporanHasilRawatInapController extends Controller
{
    public function index()
    {
        $dokter = Auth::user()->User_name;
        $dtpendaftar = PendaftaranPasienInap::where('grandtotal', '!=', 0)->orderBy('id_pendaftaran', 'desc')->paginate(10);
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('laporanhasilrawatinap.laporanhasilrawatinap', compact('dokter', 'dtpendaftar', 'menu', 'roleuser'));
    }

    public function getDataByDate(Request $request)
    {
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');
        $statusPasien = $request->input('statusPasien');
        $statusPemeriksaan = $request->input('statusPemeriksaan');

        $dataTerfilter = PendaftaranPasienInap::whereBetween('created_at', [$tglAwal, $tglAkhir])
            ->where('grandtotal', '!=', 0)
            ->when(!empty($statusPasien), function ($query) use ($statusPasien) {
                $query->where('status_pasien', $statusPasien);
            })
            ->when(!empty($statusPemeriksaan), function ($query) use ($statusPemeriksaan) {
                $query->where('status_pemeriksaan', $statusPemeriksaan);
            })
            ->with('pasien', 'user')
            ->get();

        return response()->json($dataTerfilter);
    }

    public function exportPDF(Request $request)
    {
        $rs = RumahSakit::first();
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');
        $statusPasien = $request->statusPasien;
        $statusPemeriksaan = $request->statusPemeriksaan;

        $dtpendaftar = PendaftaranPasienInap::whereBetween('created_at', [$tglAwal, $tglAkhir])
            ->where('grandtotal', '!=', 0)
            ->when(!empty($statusPasien), function ($query) use ($statusPasien) {
                $query->where('status_pasien', $statusPasien);
            })
            ->when(!empty($statusPemeriksaan), function ($query) use ($statusPemeriksaan) {
                $query->where('status_pemeriksaan', $statusPemeriksaan);
            })
            ->with('pasien', 'user')
            ->get();

        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $view = view('laporanhasilrawatinap.exportpdf', compact(
            'dtpendaftar',
            'tglAwal',
            'tglAkhir',
            'rs',
            'statusPasien',
            'statusPemeriksaan',
            'menu',
            'roleuser'
        ))->render();
        $pdf = new Dompdf();
        $pdf->loadHtml($view);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        $pdfContent = $pdf->output();

        $pdfFilePath = 'path_to_save.pdf';
        \Illuminate\Support\Facades\Storage::put($pdfFilePath, $pdfContent);

        return $pdf->stream('Laporan_Pasien_Rawat_Inap.pdf');
    }

    public function exportExcel(Request $request)
    {
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');
        $statusPasien = $request->input('statusPasien');
        $statusPemeriksaan = $request->input('statusPemeriksaan');

        $dtpendaftar = PendaftaranPasienInap::whereBetween('created_at', [$tglAwal, $tglAkhir])
            ->where('grandtotal', '!=', 0)
            ->when(!empty($statusPasien), function ($query) use ($statusPasien) {
                $query->where('status_pasien', $statusPasien);
            })
            ->when(!empty($statusPemeriksaan), function ($query) use ($statusPemeriksaan) {
                $query->where('status_pemeriksaan', $statusPemeriksaan);
            })
            ->with('pasien', 'user')
            ->get();

        return Excel::download(new laporanhasilpasienrawatinapExport($tglAwal, $tglAkhir, $statusPasien, $statusPemeriksaan), 'Laporan_Hasil_Pasien_Rawat_Inap.xlsx');
    }
}
