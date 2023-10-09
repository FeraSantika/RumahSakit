<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\DataMenu;
use App\Models\DataUser;
use App\Models\DataBarang;
use App\Models\DataPasien;
use App\Models\DataPoli;
use App\Models\Verifytoken;
use App\Models\DataRoleMenu;
use App\Models\DataSupplier;
use Illuminate\Http\Request;
use App\Models\ListDaftarObat;
use App\Models\PendaftaranPasien;
use Illuminate\Support\Facades\DB;
use App\Models\PendaftaranPasienInap;
use App\Models\Transaksi_barang_masuk;
use App\Models\Transaksi_barang_keluar;
use App\Models\ListDaftarObatPasienInap;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
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
        $pasien = DataPasien::count('pasien_id');
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $dokter = DataUser::where('Role_id', 2)->count('User_id');
        $poli = DataPoli::count('id_poli');

        $obatrawatjalan = ListDaftarObat::sum('qty');
        $obatrawatinap = ListDaftarObatPasienInap::sum('qty');
        $obat = $obatrawatjalan + $obatrawatinap;

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

        return view('home', compact(
            'pasienjalan',
            'pasieninap',
            'allDates',
            'totalspasienjalan',
            'totalspasieninap',
            'labels',
            'pasien',
            'menu',
            'roleuser',
            'obat',
            'dokter',
            'poli',
            'pasienumum',
            'pasienbpjs',
            'pasientertangani',
            'pasieninapumum',
            'pasieninapbpjs',
            'pasieninaptertangani'
        ));

        // return view('home', compact('customers', 'products', 'transactions', 'suppliers', 'tbk', 'tbm', 'allDates', 'totalsTbk', 'totalsTbm', 'labels'));

        // return view('home');
        //$get_user = User::where('email', auth()->user()->email)->first();
        // if($get_user->activated == 1){
        //  return view('home');
        // }else{
        //     return redirect('/verify-account');
        // }
    }

    // public function verifyaccount(){
    //     return view('otp_verification');
    // }

    // public function useractivation(Request $request){
    //     $get_token = $request->token;
    //     $get_token = Verifytoken::where('token', $get_token)->first();

    //     if($get_token){
    //         $get_token->activated = 1;
    //         $get_token->save();
    //         $user = User::where('email', $get_token->email)->first();
    //         $user->activated = 1;
    //         $user->save();
    //         $getting_token = Verifytoken::where('token', $get_token->token)->first();
    //         $getting_token->delete();
    //         return redirect('/home')->with('activated', 'Your Account has been activated successfully');
    //     }else{
    //         return redirect('/verify-account')->with('incorrect', 'Your OTP is Invalid please check your email once');
    //     }
    // }

    // public function tampil() {
    //     return view('dashboard-analytics');
    // }

    // public function sidebar()
    // {
    //     $menus = DataMenu::all();
    //     return view('layouts.sidebar', compact('menus'));
    // }
}
