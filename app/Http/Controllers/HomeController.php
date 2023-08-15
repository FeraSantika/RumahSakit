<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\DataBarang;
use App\Models\Verifytoken;
use App\Models\DataSupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi_barang_masuk;
use App\Models\Transaksi_barang_keluar;

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
        // $tbk =  Transaksi_barang_masuk::count('transaksi_id');
        // $tbm =  Transaksi_barang_keluar::count('transaksi_id');
        // $customers = Transaksi_barang_keluar::count('customer');
        // $products = DataBarang::count('kode_barang');
        // $transactions = $tbk + $tbm;
        // $suppliers = DataSupplier::count('kode_supplier');

        // $startDate = Carbon::now()->startOfMonth();
        // $endDate = Carbon::now()->endOfMonth();

        // Membuat array data tanggal untuk seluruh bulan
        // $labels = [];
        // $currentDate = $startDate->copy();
        // while ($currentDate <= $endDate) {
        //     $labels[] = $currentDate->format('d M Y');
        //     $currentDate->addDay();
        // }

        // Mengambil data transaksi masuk dari database
        // $tbkData = Transaksi_barang_masuk::select(
        //     DB::raw('DATE(tanggal_tbm) as tanggal'),
        //     DB::raw('COUNT(transaksi_id) as total')
        // )
        //     ->whereBetween('tanggal_tbm', [$startDate, $endDate])
        //     ->groupBy('tanggal')
        //     ->orderBy('tanggal')
        //     ->get();

        // Mengambil data transaksi keluar dari database
        // $tbmData = Transaksi_barang_keluar::select(
        //     DB::raw('DATE(tanggal_tbk) as tanggal'),
        //     DB::raw('COUNT(transaksi_id) as total')
        // )
        //     ->whereBetween('tanggal_tbk', [$startDate, $endDate])
        //     ->groupBy('tanggal')
        //     ->orderBy('tanggal')
        //     ->get();

        // Membuat array data total transaksi berdasarkan tanggal
        // $totalsTbk = [];
        // $totalsTbm = [];
        // foreach ($labels as $label) {
        //     $tanggal = Carbon::createFromFormat('d M Y', $label)->format('Y-m-d');
        //     $transaksiTbk = $tbkData->firstWhere('tanggal', $tanggal);
        //     $transaksiTbm = $tbmData->firstWhere('tanggal', $tanggal);
        //     $totalsTbk[] = $transaksiTbk ? $transaksiTbk->total : 0;
        //     $totalsTbm[] = $transaksiTbm ? $transaksiTbm->total : 0;
        // }

        // $datesFromMasuk = Transaksi_barang_masuk::pluck('tanggal_tbm')->toArray();
        // $datesFromKeluar = Transaksi_barang_keluar::pluck('tanggal_tbk')->toArray();
        // $allDates = array_unique(array_merge($datesFromMasuk, $datesFromKeluar));

        return view('home');

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
}
