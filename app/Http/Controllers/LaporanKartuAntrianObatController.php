<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\DataMenu;
use App\Models\RumahSakit;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\DataAntrianObat;
use Illuminate\Support\Facades\DB;
use App\Models\CetakDataAntrianObat;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\laporanantrianapotekerExport;
use App\Exports\laporankartuantrianapotekerExport;

class LaporanKartuAntrianObatController extends Controller
{
    public function index()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $dtantrian = CetakDataAntrianObat::get();
        return view('laporancetakantrianobat.laporanantrian', compact('menu', 'roleuser', 'dtantrian'));
    }

    public function getDataByDate(Request $request)
    {
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');

        $dataTerfilter = CetakDataAntrianObat::whereBetween('tanggal_antrian', [$tglAwal, $tglAkhir])
            ->get();
        return response()->json($dataTerfilter);
    }

    public function exportPDF(Request $request)
    {
        $rs = RumahSakit::first();
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');

        $dtantrian = CetakDataAntrianObat::whereBetween('tanggal_antrian', [$tglAwal, $tglAkhir])->get();

        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $view = view('laporancetakAntrianObat.exportpdf', compact('dtantrian', 'tglAwal', 'tglAkhir', 'rs', 'menu', 'roleuser'))->render();
        $pdf = new Dompdf();
        $pdf->loadHtml($view);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        $pdfContent = $pdf->output();

        $pdfFilePath = 'path_to_save.pdf';
        \Illuminate\Support\Facades\Storage::put($pdfFilePath, $pdfContent);

        return $pdf->stream('Laporan_Kartu_Antrian_Apotek.pdf');
    }

    public function exportExcel(Request $request)
    {
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');

        return Excel::download(new laporankartuantrianapotekerExport(
            $tglAwal,
            $tglAkhir,
        ), 'Laporan_Kartu_Antrian_Apotek.xlsx');
    }
}
