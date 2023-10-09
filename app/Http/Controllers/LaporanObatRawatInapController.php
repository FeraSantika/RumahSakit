<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\DataMenu;
use App\Models\DataPoli;
use App\Models\RumahSakit;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ListDaftarObatPasienInap;
use App\Exports\laporanobatpasienrawatinapExport;

class LaporanObatRawatInapController extends Controller
{
    public function index()
    {
        $dtobat = ListDaftarObatPasienInap::select('nama_obat', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('nama_obat')->paginate(10);
        $poli = DataPoli::all();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('laporanobatinap.laporanobat', compact('dtobat', 'menu', 'roleuser', 'poli'));
    }

    public function getDataByDate(Request $request)
    {
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');
        $statusPasien = $request->input('statusPasien');
        $statusPemeriksaan = $request->input('statusPemeriksaan');

        $dataTerfilter = DB::table('list_daftar_obat_pasieninap')
            ->join('pendaftaran_pasien_inap', 'list_daftar_obat_pasieninap.kode_pendaftaran', '=', 'pendaftaran_pasien_inap.kode_pendaftaran')
            ->select('pendaftaran_pasien_inap.*', 'list_daftar_obat_pasieninap.nama_obat', DB::raw('SUM(list_daftar_obat_pasieninap.qty) as total_qty'))
            ->whereBetween('list_daftar_obat_pasieninap.tanggal', [$tglAwal, $tglAkhir])
            ->when(!empty($statusPasien), function ($query) use ($statusPasien) {
                $query->where('pendaftaran_pasien_inap.status_pasien', $statusPasien);
            })
            ->when(!empty($statusPemeriksaan), function ($query) use ($statusPemeriksaan) {
                $query->where('pendaftaran_pasien_inap.status_pemeriksaan', $statusPemeriksaan);
            })
            ->groupBy('list_daftar_obat_pasieninap.nama_obat')
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

        $dtobat = DB::table('list_daftar_obat_pasieninap')
            ->join('pendaftaran_pasien_inap', 'list_daftar_obat_pasieninap.kode_pendaftaran', '=', 'pendaftaran_pasien_inap.kode_pendaftaran')
            ->select('pendaftaran_pasien_inap.*', 'list_daftar_obat_pasieninap.nama_obat', DB::raw('SUM(list_daftar_obat_pasieninap.qty) as total_qty'))
            ->whereBetween('list_daftar_obat_pasieninap.tanggal', [$tglAwal, $tglAkhir])
            ->when(!empty($statusPasien), function ($query) use ($statusPasien) {
                $query->where('pendaftaran_pasien_inap.status_pasien', $statusPasien);
            })
            ->when(!empty($statusPemeriksaan), function ($query) use ($statusPemeriksaan) {
                $query->where('pendaftaran_pasien_inap.status_pemeriksaan', $statusPemeriksaan);
            })
            ->groupBy('list_daftar_obat_pasieninap.nama_obat')
            ->get();

        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $view = view('laporanobatinap.exportpdf', compact('dtobat', 'tglAwal', 'tglAkhir', 'rs', 'menu', 'roleuser', 'statusPasien', 'statusPemeriksaan'))->render();
        $pdf = new Dompdf();
        $pdf->loadHtml($view);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        $pdfContent = $pdf->output();

        $pdfFilePath = 'path_to_save.pdf';
        \Illuminate\Support\Facades\Storage::put($pdfFilePath, $pdfContent);

        return $pdf->stream('Laporan_Obat_Pasien_Rawat_Inap.pdf');
    }

    public function exportExcel(Request $request)
    {
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');
        $statusPasien = $request->input('statusPasien');
        $statusPemeriksaan = $request->input('statusPemeriksaan');

        $query = DB::table('list_daftar_obat_pasieninap')
            ->join('pendaftaran_pasien_inap', 'list_daftar_obat_pasieninap.kode_pendaftaran', '=', 'pendaftaran_pasien_inap.kode_pendaftaran')
            ->select('pendaftaran_pasien_inap.*', 'list_daftar_obat_pasieninap.nama_obat', DB::raw('SUM(list_daftar_obat_pasieninap.qty) as total_qty'))
            ->whereBetween('list_daftar_obat_pasieninap.tanggal', [$tglAwal, $tglAkhir])
            ->when(!empty($statusPasien), function ($query) use ($statusPasien) {
                $query->where('pendaftaran_pasien_inap.status_pasien', $statusPasien);
            })
            ->when(!empty($statusPemeriksaan), function ($query) use ($statusPemeriksaan) {
                $query->where('pendaftaran_pasien_inap.status_pemeriksaan', $statusPemeriksaan);
            })
            ->groupBy('list_daftar_obat_pasieninap.nama_obat')
            ->get();

        return Excel::download(new laporanobatpasienrawatinapExport($tglAwal, $tglAkhir, $statusPasien, $statusPemeriksaan), 'Laporan_Obat_Pasien_Rawat_Inap.xlsx');
    }
}
