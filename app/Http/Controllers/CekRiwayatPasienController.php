<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\DataPasien;
use App\Models\RumahSakit;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\KamarPasienInap;
use App\Models\PendaftaranPasien;
use App\Models\PendaftaranPasienInap;

class CekRiwayatPasienController extends Controller
{
    public function index()
    {
        $rs = RumahSakit::first();
        return view('cekriwayatpasien.formpencarian', compact('rs'));
    }

    public function cari(Request $request)
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $nik = $request->nik;
        $tgl_lahir =  $request->tanggal;
        $pasien = DataPasien::where('pasien_NIK', $nik)
            ->where('pasien_tgl_lahir', $tgl_lahir)
            ->get();

        foreach ($pasien as $singlePasien) {
            $pasien_id = $singlePasien->pasien_id;
        }
        if ($pasien) {
            $dtriwayat = PendaftaranPasien::where('pasien_id', $pasien_id)
                ->where('status_pemeriksaan', 'Tertangani')
                ->with('user', 'listobat', 'listtindakan', 'listrujukan.lab', 'pasien')->get();

            $dtriwayatinap = PendaftaranPasienInap::where('pasien_id', $pasien_id)->where('status_pemeriksaan', 'Tertangani')
                ->with('user', 'listobat', 'listtindakan', 'listrujukan.lab', 'pasien')->get();

            if ($dtriwayatinap) {
                $kode_pendaftaran = [];
                foreach ($dtriwayatinap as $item) {
                    $kode_pendaftaran[] = $item->kode_pendaftaran;
                }
                $dtlistkamar =  KamarPasienInap::where('kode_pendaftaran', $kode_pendaftaran)->with('kamar')->get();
                return view('cekriwayatpasien.riwayatmedispasien', compact('dtriwayat', 'dtriwayatinap', 'menu', 'roleuser', 'dtlistkamar', 'pasien'));
            } else {
                return view('cekriwayatpasien.riwayatmedispasien', compact('dtriwayat', 'dtriwayatinap', 'menu', 'roleuser', 'pasien'));
            }
        } else {
            $rs = RumahSakit::first();
            return view('cekriwayatpasien.formpencarian', compact('rs'));
        }
    }
}
