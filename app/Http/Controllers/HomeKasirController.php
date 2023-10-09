<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\DataMenu;
use App\Models\DataPoli;
use App\Models\DataUser;
use App\Models\DataPasien;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\PendaftaranPasien;
use Illuminate\Support\Facades\DB;
use App\Models\PendaftaranPasienInap;

class HomeKasirController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $pasienjalan =  PendaftaranPasien::where('grandtotal', '!=', 0)->count('id_pendaftaran');

        $pasienumum = PendaftaranPasien::where('grandtotal', '!=', 0)->where('status_pasien', 'Umum')
            ->count();
        $pasienbpjs = PendaftaranPasien::where('status_pasien', 'BPJS')->where('grandtotal', '!=', 0)
            ->count();
        $pasientertangani = PendaftaranPasien::where('status_pemeriksaan', 'Tertangani')->where('grandtotal', '!=', 0)
            ->count();

        $pasieninap =  PendaftaranPasienInap::where('grandtotal', '!=', 0)->count('id_pendaftaran');

        $pasieninapumum = PendaftaranPasienInap::where('status_pasien', 'Umum')->where('grandtotal', '!=', 0)->count();
        $pasieninapbpjs = PendaftaranPasienInap::where('status_pasien', 'BPJS')->where('grandtotal', '!=', 0)
            ->count();
        $pasieninaptertangani = PendaftaranPasienInap::where('status_pemeriksaan', 'Tertangani')->where('grandtotal', '!=', 0)
            ->count();

        $pasien = DataPasien::count('pasien_id');
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $dokter = DataUser::where('Role_id', 2)->count('User_id');
        $poli = DataPoli::count('id_poli');
        $pembayaranjalan = PendaftaranPasien::where('grandtotal', '!=', 0)->sum('grandtotal');
        $pembayaraninap = PendaftaranPasienInap::where('grandtotal', '!=', 0)->sum('grandtotal');

        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        // Membuat array data tanggal untuk seluruh bulan
        $labels = [];
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $labels[] = $currentDate->format('d M Y');
            $currentDate->addDay();
        }

        // Mengambil data Pendaftaran Pasien Rawat Jalan dari database
        $pasienjalanData = PendaftaranPasien::select(
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw('COUNT(id_pendaftaran) as total')
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Mengambil data Pendaftaran Pasien Rawat Inap dari database
        $pasieninapData = PendaftaranPasienInap::select(
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw('COUNT(id_pendaftaran) as total')
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Membuat array data total transaksi berdasarkan tanggal
        $totalspasienjalan = [];
        $totalspasieninap = [];
        foreach ($labels as $label) {
            $tanggal = Carbon::createFromFormat('d M Y', $label)->format('Y-m-d');
            $transaksipasienjalan = $pasienjalanData->firstWhere('tanggal', $tanggal);
            $transaksipasieninap = $pasieninapData->firstWhere('tanggal', $tanggal);
            $totalspasienjalan[] = $transaksipasienjalan ? $transaksipasienjalan->total : 0;
            $totalspasieninap[] = $transaksipasieninap ? $transaksipasieninap->total : 0;
        }

        $datesFrompasienjalan = PendaftaranPasien::pluck('created_at')->toArray();
        $datesFrompasieninap = PendaftaranPasienInap::pluck('created_at')->toArray();
        $allDates = array_unique(array_merge($datesFrompasienjalan, $datesFrompasieninap));

        return view('home-kasir', compact(
            'pasienjalan',
            'pasieninap',
            'allDates',
            'totalspasienjalan',
            'totalspasieninap',
            'labels',
            'pasien',
            'menu',
            'roleuser',
            'poli',
            'dokter',
            'pembayaranjalan',
            'pembayaraninap',
            'pasienumum',
            'pasienbpjs',
            'pasientertangani',
            'pasieninapumum',
            'pasieninapbpjs',
            'pasieninaptertangani'
        ));
    }
}
