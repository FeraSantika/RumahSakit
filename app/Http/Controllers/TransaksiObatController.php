<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\ListDaftarObat;
use App\Models\PendaftaranPasien;
use App\Models\ListDaftarTindakan;

class TransaksiObatController extends Controller
{
    public function index()
    {
        $dtpendaftar = PendaftaranPasien::where('status_pemeriksaan', 'Tertangani')->with('pasien')->orderBy('kode_pendaftaran', 'desc')->paginate(10);
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('transaksiobat.transaksiobat', compact('dtpendaftar', 'menu', 'roleuser'));
    }

    public function detail($id)
    {
        $dtpendaftar = PendaftaranPasien::where('kode_pendaftaran', $id)->with('pasien')->get();
        $dtlistobat =  ListDaftarObat::where('kode_pendaftaran', $id)->get();
        $dtlisttindakan =  ListDaftarTindakan::where('kode_pendaftaran', $id)->get();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();

        foreach ($dtpendaftar as $pendaftaran) {
            $pasien_id = $pendaftaran->pasien_id;
            $dtriwayat = PendaftaranPasien::where('pasien_id', $pasien_id)->where('status_pemeriksaan', 'Tertangani')->with('poli', 'user', 'listobat', 'listtindakan')->get();
        }
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('transaksiobat.detail', compact('dtpendaftar', 'dtriwayat', 'dtlistobat', 'dtlisttindakan', 'roleuser', 'menu'));
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

        $data = PendaftaranPasien::where('status_pemeriksaan', 'Tertangani')->with('pasien')
            ->where(function ($query) use ($searchTerm) {
                $query->whereHas('pasien', function ($subquery) use ($searchTerm) {
                    $subquery->where('pasien_nama', 'LIKE', '%' . $searchTerm . '%');
                });
            })
            ->get();

        return response()->json($data);
    }
}
