<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\DataObat;
use App\Models\DataPoli;
use App\Models\DataUser;
use App\Models\kategori;
use App\Models\DataPasien;
use App\Models\DataAntrian;
use App\Models\DataAntrianObat;
use App\Models\DataRoleMenu;
use App\Models\DataTindakan;
use App\Models\JadwalDokter;
use Illuminate\Http\Request;
use App\Models\ListDaftarObat;
use Illuminate\Support\Carbon;
use App\Models\PendaftaranPasien;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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

    public function antrian()
    {
        $user = Auth::user();
        $akses = $user->poliakses;

        $today = now()->format('Y-m-d');

        $antrian = DataAntrianObat::whereDate('tanggal_antrian', $today)->first();
        $pasienjalan =  PendaftaranPasien::with(['aksespoli.user'])
            ->whereHas('aksespoli.user', function ($query) use ($user) {
                $query->where('User_id', $user->User_id);
            })->count('id_pendaftaran');

        $pasienumum = PendaftaranPasien::with(['aksespoli.user'])
            ->whereHas('aksespoli.user', function ($query) use ($user) {
                $query->where('User_id', $user->User_id);
            })
            ->where('status_pasien', 'Umum')
            ->count();

        $pasienbpjs = PendaftaranPasien::with(['aksespoli.user'])
            ->whereHas('aksespoli.user', function ($query) use ($user) {
                $query->where('User_id', $user->User_id);
            })
            ->where('status_pasien', 'BPJS')
            ->count();

        $pasientertangani = PendaftaranPasien::with(['aksespoli.user'])
            ->whereHas('aksespoli.user', function ($query) use ($user) {
                $query->where('User_id', $user->User_id);
            })
            ->where('status_pemeriksaan', 'Tertangani')
            ->count();

        $pasieninap =  PendaftaranPasienInap::count('id_pendaftaran');
        $pasieninapumum = PendaftaranPasienInap::where('status_pasien', 'Umum')->count();
        $pasieninapbpjs = PendaftaranPasienInap::where('status_pasien', 'BPJS')
            ->count();
        $pasieninaptertangani = PendaftaranPasienInap::where('status_pemeriksaan', 'Tertangani')
            ->count();
        $pasien = DataPasien::count('pasien_id');

        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $poli = DataPoli::count('id_poli');
        $obat = DataObat::count('kode_obat');
        $tindakan = DataTindakan::count('id_tindakan');

        $jadwaldokter = JadwalDokter::where('User_id', $user->User_id)
            ->leftjoin('data_hari', 'data_hari.nama_hari', '=', 'jadwal_dokter.nama_hari')->orderBy('id_hari', 'ASC')->get();


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
        return view('antrian-apoteker', compact(
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
            'obat',
            'tindakan',
            'jadwaldokter',
            'pasienumum',
            'pasienbpjs',
            'pasientertangani',
            'pasieninapumum',
            'pasieninapbpjs',
            'pasieninaptertangani',
            'antrian'
        ));
    }
}
