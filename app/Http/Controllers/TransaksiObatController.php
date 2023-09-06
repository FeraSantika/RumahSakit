<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListDaftarObat;
use App\Models\PendaftaranPasien;
use App\Models\ListDaftarTindakan;

class TransaksiObatController extends Controller
{
    public function index()
    {
        $dtpendaftar = PendaftaranPasien::where('status_pemeriksaan', 'Tertangani')->with('pasien')->orderBy('kode_pendaftaran', 'desc')->paginate(10);
        return view('transaksiobat.transaksiobat', compact('dtpendaftar'));
    }

    public function detail($id)
    {
        $dtpendaftar = PendaftaranPasien::where('kode_pendaftaran', $id)->with('pasien')->get();
        $dtlistobat =  ListDaftarObat::where('kode_pendaftaran', $id)->get();
        $dtlisttindakan =  ListDaftarTindakan::where('kode_pendaftaran', $id)->get();

        foreach ($dtpendaftar as $pendaftaran) {
            $pasien_id = $pendaftaran->pasien_id;
            $dtriwayat = PendaftaranPasien::where('pasien_id', $pasien_id)->where('status_pemeriksaan', 'Tertangani')->with('poli', 'user', 'listobat', 'listtindakan')->get();
        }
        return view('transaksiobat.detail', compact('dtpendaftar', 'dtriwayat', 'dtlistobat', 'dtlisttindakan'));
    }

    public function updateObat($id)
    {
        $updatedData = [
            'status_obat' => 'Tertangani'
        ];
        PendaftaranPasien::where('kode_pendaftaran', $id)->update($updatedData);

        return redirect()->route('transaksi-obat');
    }

    public function updatelist(Request $request)
    {
        $updatedData = [
            'status' => $request->status,
        ];

        ListDaftarObat::where('list_id', $request->list_id)->update($updatedData);

        $responseData = [
            'success' => true,
            'message' => 'Data Berhasil Diubah!',
            'data' => $updatedData
        ];

        return response()->json($responseData);
    }

    public function search(Request $request)
    {
        $searchTerm = $request->get('cari');

        $data = PendaftaranPasien::with('pasien')
            ->where(function ($query) use ($searchTerm) {
                $query->whereHas('pasien', function ($subquery) use ($searchTerm) {
                    $subquery->where('pasien_nama', 'LIKE', '%' . $searchTerm . '%');
                });
            })
            ->get();

        return response()->json($data);
    }
}
