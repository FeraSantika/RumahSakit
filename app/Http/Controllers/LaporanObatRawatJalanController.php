<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\DataMenu;
use App\Models\DataPoli;
use App\Models\RumahSakit;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\ListDaftarObat;
use App\Models\PendaftaranPasien;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\laporanobatpasienrawatjalanExport;

class LaporanObatRawatJalanController extends Controller
{
    public function index()
    {
        $dtobat = ListDaftarObat::select('nama_obat', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('nama_obat')->paginate(10);
        $poli = DataPoli::all();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('laporanobatjalan.laporanobat', compact('dtobat', 'menu', 'roleuser', 'poli'));
    }

    public function getDataByDate(Request $request)
    {
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');
        $statusPasien = $request->input('statusPasien');
        $pilihPoli = $request->input('pilihPoli');
        $statusPemeriksaan = $request->input('statusPemeriksaan');

        $dataTerfilter = DB::table('list_daftar_obat_pasien')
            ->join('pendaftaran_pasien', 'list_daftar_obat_pasien.kode_pendaftaran', '=', 'pendaftaran_pasien.kode_pendaftaran')
            ->select('pendaftaran_pasien.*', 'list_daftar_obat_pasien.nama_obat', DB::raw('SUM(list_daftar_obat_pasien.qty) as total_qty'))
            ->whereBetween('list_daftar_obat_pasien.created_at', [$tglAwal, $tglAkhir])
            ->when(!empty($statusPasien), function ($query) use ($statusPasien) {
                $query->where('pendaftaran_pasien.status_pasien', $statusPasien);
            })
            ->when(!empty($pilihPoli), function ($query) use ($pilihPoli) {
                $query->where('pendaftaran_pasien.id_poli', $pilihPoli);
            })
            ->when(!empty($statusPemeriksaan), function ($query) use ($statusPemeriksaan) {
                $query->where('pendaftaran_pasien.status_pemeriksaan', $statusPemeriksaan);
            })
            ->groupBy('list_daftar_obat_pasien.nama_obat')
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

        $query = DB::table('list_daftar_obat_pasien')
            ->join('pendaftaran_pasien', 'list_daftar_obat_pasien.kode_pendaftaran', '=', 'pendaftaran_pasien.kode_pendaftaran')
            ->select('pendaftaran_pasien.*', 'list_daftar_obat_pasien.nama_obat', DB::raw('SUM(list_daftar_obat_pasien.qty) as total_qty'))
            ->whereBetween('list_daftar_obat_pasien.created_at', [$tglAwal, $tglAkhir])
            ->when(!empty($statusPasien), function ($query) use ($statusPasien) {
                $query->where('pendaftaran_pasien.status_pasien', $statusPasien);
            })
            ->when(!empty($pilihPoli), function ($query) use ($pilihPoli) {
                $query->where('pendaftaran_pasien.id_poli', $pilihPoli);
            })
            ->when(!empty($statusPemeriksaan), function ($query) use ($statusPemeriksaan) {
                $query->where('pendaftaran_pasien.status_pemeriksaan', $statusPemeriksaan);
            })
            ->groupBy('list_daftar_obat_pasien.nama_obat');

        $dtobat = $query->get();

        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $view = view('laporanobatjalan.exportpdf', compact('dtobat', 'tglAwal', 'tglAkhir', 'rs', 'menu', 'roleuser', 'statusPasien', 'statusPemeriksaan', 'pilihPoli'))->render();
        $pdf = new Dompdf();
        $pdf->loadHtml($view);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        $pdfContent = $pdf->output();

        $pdfFilePath = 'path_to_save.pdf';
        \Illuminate\Support\Facades\Storage::put($pdfFilePath, $pdfContent);

        return $pdf->stream('Laporan_Obat_Pasien_Rawat_Jalan.pdf');
    }

    public function exportExcel(Request $request)
    {
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');
        $statusPasien = $request->input('statusPasien');
        $pilihPoli = $request->input('pilihPoli');
        $statusPemeriksaan = $request->input('statusPemeriksaan');

        $query = DB::table('list_daftar_obat_pasien')
            ->join('pendaftaran_pasien', 'list_daftar_obat_pasien.kode_pendaftaran', '=', 'pendaftaran_pasien.kode_pendaftaran')
            ->select('pendaftaran_pasien.*', 'list_daftar_obat_pasien.nama_obat', DB::raw('SUM(list_daftar_obat_pasien.qty) as total_qty'))
            ->whereBetween('list_daftar_obat_pasien.created_at', [$tglAwal, $tglAkhir])
            ->when(!empty($statusPasien), function ($query) use ($statusPasien) {
                $query->where('pendaftaran_pasien.status_pasien', $statusPasien);
            })
            ->when(!empty($pilihPoli), function ($query) use ($pilihPoli) {
                $query->where('pendaftaran_pasien.id_poli', $pilihPoli);
            })
            ->when(!empty($statusPemeriksaan), function ($query) use ($statusPemeriksaan) {
                $query->where('pendaftaran_pasien.status_pemeriksaan', $statusPemeriksaan);
            })->get();

        return Excel::download(new laporanobatpasienrawatjalanExport(
            $tglAwal,
            $tglAkhir,
            $statusPasien,
            $pilihPoli,
            $statusPemeriksaan
        ), 'Laporan_Obat_Pasien_Rawat_Jalan.xlsx');
    }
}
