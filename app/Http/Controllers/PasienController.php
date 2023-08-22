<?php

namespace App\Http\Controllers;

use App\Models\DataObat;
use App\Models\DataPasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index()
    {
        $dtpasien =  DataPasien::paginate(10);
        return view('pasien.pasien', compact('dtpasien'));
    }

    public function create()
    {
        $dtpasien = DataPasien::get();
        $prefix = 'PSN';
        $length = 4;
        $lastpasien = DataPasien::orderBy('pasien_id', 'desc')->first();
        if ($lastpasien) {
            $lastId = (int) substr($lastpasien->pasien_kode, strlen($prefix));
        } else {
            $lastId = 0;
        }
        $nextId = $lastId + 1;
        $paddedId = str_pad($nextId, $length, '0', STR_PAD_LEFT);
        $pasienCode = $prefix . $paddedId;
        return view('pasien.create', compact('dtpasien', 'lastpasien', 'pasienCode'));
    }


    public function store(Request $request)
    {
        $existingPasien = DataPasien::where('pasien_NIK', $request->NIK)->first();

        if ($existingPasien) {
            return back()->withInput()->with('error', 'NIK sudah terdaftar. Mohon gunakan NIK lain.');
        }

        $pasien = DataPasien::create([
            'pasien_nama' => $request->nama,
            'pasien_NIK' => $request->NIK,
            'pasien_kode' => $request->kode,
            'pasien_tempat_lahir' => $request->tempat,
            'pasien_tgl_lahir' => $request->tgl,
            'pasien_jenis_kelamin' => $request->gender,
            'pasien_alamat' => $request->alamat,
            'pasien_agama' => $request->agama,
            'pasien_status' => $request->perkawinan,
            'pasien_pekerjaan' => $request->pekerjaan,
            'pasien_kewarganegaraan' => $request->kewarganegaraan,
        ]);

        $prefix = 'PSN';
        $length = 4;
        $lastpasien = DataPasien::orderBy('pasien_id', 'desc')->first();
        if ($lastpasien) {
            $lastId = (int) substr($lastpasien->pasien_kode, strlen($prefix));
        } else {
            $lastId = 0;
        }

        $nextId = $lastId + 1;
        $paddedId = str_pad($nextId, $length, '0', STR_PAD_LEFT);
        $newpasienCode = $prefix . $paddedId;

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data' => $pasien,
            'new_kode' => $newpasienCode
        ]);
    }

    public function edit($id)
    {
        $dtpasien =  DataPasien::where('pasien_id', $id)->first();
        return view('pasien.edit', compact('dtpasien'));
    }

    public function update(Request $request, $id)
    {
        $dtpasien = [
            'pasien_nama' => $request->nama,
            'pasien_NIK' => $request->NIK,
            'pasien_tempat_lahir' => $request->tempat,
            'pasien_tgl_lahir' => $request->tgl,
            'pasien_jenis_kelamin' => $request->gender,
            'pasien_alamat' => $request->alamat,
            'pasien_agama' => $request->agama,
            'pasien_status' => $request->perkawinan,
            'pasien_pekerjaan' => $request->pekerjaan,
            'pasien_kewarganegaraan' => $request->kewarganegaraan,
        ];

        DataPasien::where('pasien_id', $id)->update($dtpasien);

        return redirect()->route('pasien');
    }

    public function destroy($id)
    {
        $dt = DataPasien::where('pasien_id', $id);
        $dt->delete();
        return redirect()->route('pasien');
    }

    public function autocomplete(Request $request)
    {
        $data = DataObat::select("nama_obat as label", "kode_kategori as value", "harga_jual as label1", "diskon_obat as label2", "stok_obat as label3")
            ->where('nama_obat', 'LIKE', '%' . $request->get('cari') . '%')
            ->get();

        return response()->json($data);
    }

    public function search(Request $request)
    {
        $searchTerm = $request->get('cari');

        $data = DataPasien::where('pasien_nama', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('pasien_kode', 'LIKE', '%' . $request->get('cari') . '%')
            ->orWhere('pasien_nama', 'LIKE', '%' . $request->get('cari') . '%')
            ->orWhere('pasien_NIK', 'LIKE', '%' . $request->get('cari') . '%')
            ->orWhere('pasien_tempat_lahir', 'LIKE', '%' . $request->get('cari') . '%')
            ->orWhere('pasien_tgl_lahir', 'LIKE', '%' . $request->get('cari') . '%')
            ->orWhere('pasien_jenis_kelamin', 'LIKE', '%' . $request->get('cari') . '%')
            ->orWhere('pasien_alamat', 'LIKE', '%' . $request->get('cari') . '%')
            ->get();

        return response()->json($data);
    }

    public function detail($id)
    {
        $dtpasien =  DataPasien::where('pasien_id', $id)->first();
        return view('pasien.detailpasien', compact('dtpasien'));
    }
}
