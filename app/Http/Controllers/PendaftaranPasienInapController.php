<?php

namespace App\Http\Controllers;

use App\Models\DataPasien;
use Illuminate\Http\Request;
use App\Models\PendaftaranPasienInap;

class PendaftaranPasienInapController extends Controller
{
    public function index()
    {
        $dtpendaftaran = PendaftaranPasienInap::with('pasien')->paginate(10);
        return view('daftar-rawatinap.daftar', compact('dtpendaftaran'));
    }

    public function create(Request $request)
    {
        $prefix = 'DFTR';
        $length = 4;
        $lastpendaftaran = PendaftaranPasienInap::orderBy('id_pendaftaran', 'desc')->first();
        if ($lastpendaftaran) {
            $lastId = (int) substr($lastpendaftaran->kode_pendaftaran, strlen($prefix));
        } else {
            $lastId = 0;
        }

        $nextId = $lastId + 1;

        $paddedId = str_pad($nextId, $length, '0', STR_PAD_LEFT);
        $pendaftaranCode = $prefix . $paddedId;

        $dtpasien = DataPasien::get();

        return view('daftar-rawatinap.create', compact('dtpasien', 'lastpendaftaran', 'pendaftaranCode'));
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
        $status_pasien = $request->input('status', 'Umum');

        $daftar = PendaftaranPasienInap::create([
            'kode_pendaftaran' => $request->kode,
            'pasien_id' => $request->pasien_id,
            'keluhan' => $request->keluhan,
            'status_pasien' => $status_pasien,
        ]);

        $prefix = 'DFTR';
        $length = 4;
        $lastpendaftaran = PendaftaranPasienInap::orderBy('id_pendaftaran', 'desc')->first();
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
        $dtpendaftaran =  PendaftaranPasienInap::where('id_pendaftaran', $id)->with('pasien')->first();
        return view('daftar-rawatinap.edit', compact('dtpendaftaran', 'dtpasien'));
    }

    public function update(Request $request, $id)
    {
        $dtpendaftaran = [
            'keluhan' => $request->keluhan,
            'status_pasien' => $request->status_pasien
        ];

        PendaftaranPasienInap::where('id_pendaftaran', $id)->update($dtpendaftaran);

        return redirect()->route('daftar.pasieninap');
    }

    public function destroy($id)
    {
        PendaftaranPasienInap::where('id_pendaftaran', $id)->delete();
        return redirect()->route('daftar.pasieninap');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->get('cari');

        $data = PendaftaranPasienInap::with('pasien')
            ->where(function ($query) use ($searchTerm) {
                $query->whereHas('pasien', function ($subquery) use ($searchTerm) {
                    $subquery->where('pasien_nama', 'LIKE', '%' . $searchTerm . '%');
                })
                    ->orWhere('kode_pendaftaran', 'LIKE', '%' . $searchTerm . '%');
            })
            ->get();

        return response()->json($data);
    }
}
