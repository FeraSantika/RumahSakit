<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\DataObat;
use App\Models\DataPoli;
use App\Models\DataUser;
use App\Models\kategori;
use App\Models\DataPasien;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\ListDaftarObat;
use Illuminate\Support\Carbon;
use App\Models\PendaftaranPasien;
use Illuminate\Support\Facades\DB;
use App\Models\PendaftaranPasienInap;
use App\Models\ListDaftarObatPasienInap;

class HomeApotekerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $pasienjalan =  PendaftaranPasien::count('id_pendaftaran');

        $pasienumum = PendaftaranPasien::where('status_pasien', 'Umum')
            ->count();
        $pasienbpjs = PendaftaranPasien::where('status_pasien', 'BPJS')
            ->count();
        $pasientertangani = PendaftaranPasien::where('status_pemeriksaan', 'Tertangani')
            ->count();

        $pasieninap =  PendaftaranPasienInap::count('id_pendaftaran');

        $pasieninapumum = PendaftaranPasienInap::where('status_pasien', 'Umum')->count();
        $pasieninapbpjs = PendaftaranPasienInap::where('status_pasien', 'BPJS')
            ->count();
        $pasieninaptertangani = PendaftaranPasienInap::where('status_pemeriksaan', 'Tertangani')
            ->count();

        $kategoriobat = kategori::count('kode_kategori');
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $obat = DataObat::count('kode_obat');
        $apoteker = DataUser::where('Role_id', 4)->count('User_id');
        $dokter = DataUser::where('Role_id', 2)->count('User_id');
        $poli = DataPoli::count('id_poli');

        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $labels = [];
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $labels[] = $currentDate->format('d M Y');
            $currentDate->addDay();
        }

        $pasienjalanData = PendaftaranPasien::select(
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw('COUNT(id_pendaftaran) as total')
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $pasieninapData = PendaftaranPasienInap::select(
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw('COUNT(id_pendaftaran) as total')
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

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

        return view('home-apoteker', compact(
            'pasienjalan',
            'pasieninap',
            'kategoriobat',
            'allDates',
            'totalspasienjalan',
            'totalspasieninap',
            'labels',
            'menu',
            'roleuser',
            'obat',
            'apoteker',
            'dokter',
            'poli',
            'pasienumum',
            'pasienbpjs',
            'pasientertangani',
            'pasieninapumum',
            'pasieninapbpjs',
            'pasieninaptertangani'
        ));
    }
}
