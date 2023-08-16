<?php

namespace App\Http\Controllers;

use App\Models\DataPoli;
use App\Models\DataPasien;
use Illuminate\Http\Request;
use App\Models\PendaftaranPasien;
use App\Models\pendaftaran_pasien;

class DaftaronlineController extends Controller
{
    public function index()
    {
        $dtpendaftaran = PendaftaranPasien::with('pasien', 'poli');
        return view('daftar-online.daftar', compact('dtpendaftaran'));
    }

    public function create(Request $request)
    {
        $prefix = 'DFTR';
        $length = 4;
        $lastpendaftaran = PendaftaranPasien::orderBy('id_pendaftaran', 'desc')->first();
        if ($lastpendaftaran) {
            $lastId = (int) substr($lastpendaftaran->kode_pendaftaran, strlen($prefix));
        } else {
            $lastId = 0;
        }

        $nextId = $lastId + 1;

        $paddedId = str_pad($nextId, $length, '0', STR_PAD_LEFT);
        $pendaftaranCode = $prefix . $paddedId;

        $dtpasien = DataPasien::get();
        $dtpoli = DataPoli::get();

        // $data = DataPasien::select("pasien_nama as value", "pasien_NIK")
        // ->where('pasien_nama', 'LIKE', '%' . $request->get('cari') . '%')
        // ->orWhere('pasien_NIK', 'LIKE', '%' . $request->get('cari') . '%')
        // ->get();

        // dd($data);
        return view('daftar-online.create', compact('dtpasien', 'dtpoli', 'lastpendaftaran', 'pendaftaranCode'));
    }

    public function autocomplete(Request $request)
    {
        $data = DataPasien::select("pasien_nama as value", "pasien_NIK")
            ->where('pasien_nama', 'LIKE', '%' . $request->get('cari') . '%')
            ->orWhere('pasien_NIK', 'LIKE', '%' . $request->get('cari') . '%')
            ->get();

        return response()->json($data);
    }
}
