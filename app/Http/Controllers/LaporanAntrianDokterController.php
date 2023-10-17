<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\DataMenu;
use App\Models\DataPoli;
use App\Models\RumahSakit;
use App\Models\DataAntrian;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\laporanantrianpasienrawatjalanExport;

class LaporanAntrianDokterController extends Controller
{
    public function index()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $poli = DataPoli::all();
        $dtantrian =  DataAntrian::with('poli')->orderBy('tanggal_antrian')->get();
        // dd($dtantrian);
        return view('laporanantriandokter.laporanantrian', compact('menu', 'roleuser', 'poli', 'dtantrian'));
    }

    public function getDataByDate(Request $request)
    {
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');
        $pilihPoli = $request->input('pilihPoli');

        $dataTerfilter = DataAntrian::with('poli')
            ->whereBetween('tanggal_antrian', [$tglAwal, $tglAkhir])
            ->when(!empty($pilihPoli), function ($query) use ($pilihPoli) {
                $query->where('id_poli', $pilihPoli);
            })->orderBy('tanggal_antrian')
            ->get();

        return response()->json($dataTerfilter);
    }

    public function exportPDF(Request $request)
    {
        $rs = RumahSakit::first();
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');
        $pilihPoli = $request->input('pilihPoli');

        $antrian = DataAntrian::with('poli')
            ->whereBetween('tanggal_antrian', [$tglAwal, $tglAkhir])
            ->when(!empty($pilihPoli), function ($query) use ($pilihPoli) {
                $query->where('id_poli', $pilihPoli);
            })
            ->get();

        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $view = view('laporanAntrianDokter.exportpdf', compact('antrian', 'tglAwal', 'tglAkhir', 'rs', 'menu', 'roleuser', 'pilihPoli'))->render();
        $pdf = new Dompdf();
        $pdf->loadHtml($view);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        $pdfContent = $pdf->output();

        $pdfFilePath = 'path_to_save.pdf';
        \Illuminate\Support\Facades\Storage::put($pdfFilePath, $pdfContent);

        return $pdf->stream('Laporan_Antrian_Pasien_Rawat_Jalan.pdf');
    }

    public function exportExcel(Request $request)
    {
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');
        $pilihPoli = $request->input('pilihPoli');

        return Excel::download(new laporanantrianpasienrawatjalanExport(
            $tglAwal,
            $tglAkhir,
            $pilihPoli,
        ), 'Laporan_Antrian_Pasien_Rawat_Jalan.xlsx');
    }
}
