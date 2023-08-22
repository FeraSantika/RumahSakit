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
        $dtpendaftaran = PendaftaranPasien::with('pasien', 'poli')->get();
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
        $data = DataPasien::select("pasien_nama as label", "pasien_NIK as value", "pasien_tgl_lahir as label2", "pasien_jenis_kelamin as value2", "pasien_id as value3")
            ->where('pasien_nama', 'LIKE', '%' . $request->get('cari') . '%')
            ->orWhere('pasien_NIK', 'LIKE', '%' . $request->get('cari') . '%')
            ->get();

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $daftar = PendaftaranPasien::create([
            'kode_pendaftaran' => $request->kode,
            'pasien_id' => $request->pasien_id,
            'id_poli' => $request->poli,
            'keluhan' => $request->keluhan,
        ]);

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
        $newpendaftaranCode = $prefix . $paddedId;

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data' => $daftar,
            'new_kode' => $newpendaftaranCode
        ]);
    }

    public function edit($id)
    {
        $dtpasien = DataPasien::get();
        $dtpoli = DataPoli::get();
        $dtpendaftaran =  PendaftaranPasien::where('id_pendaftaran', $id)->with('pasien', 'poli')->first();
        return view('daftar-online.edit', compact('dtpendaftaran', 'dtpasien', 'dtpoli'));
    }

    public function update(Request $request, $id)
    {
        $dtpendaftaran = [
            'id_poli' => $request->poli,
            'keluhan' => $request->keluhan,
        ];

        PendaftaranPasien::where('id_pendaftaran', $id)->update($dtpendaftaran);

        return redirect()->route('daftar.online');
    }

    public function destroy($id)
    {
        $dt = PendaftaranPasien::where('id_pendaftaran', $id);
        $dt->delete();
        return redirect()->route('daftar.online');
    }
}