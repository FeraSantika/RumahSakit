<?php

namespace App\Http\Controllers;

use App\Models\DataObat;
use App\Models\DataPasien;
use PharIo\Manifest\Author;
use App\Models\DataTindakan;
use Illuminate\Http\Request;
use App\Models\DataAksesPoli;
use App\Models\ListDaftarObat;
use App\Models\PendaftaranPasien;
use App\Models\ListDaftarTindakan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ListdaftarpasienController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $akses = $user->poliakses;
        $dtpendaftar = PendaftaranPasien::with(['aksespoli.user'])
            ->whereHas('aksespoli.user', function ($query) use ($user) {
                $query->where('User_id', $user->User_id);
            })
            ->paginate(10);
        return view('listdaftarpasien.listdaftarpasien', compact('dtpendaftar'));
    }

    public function autocomplete(Request $request)
    {
        $data = DataObat::with('kategori')->select(
            "nama_obat as label",
            DB::raw("(SELECT nama_kategori FROM kategori WHERE kategori.kode_kategori = data_obat.kode_kategori) as value"),
            "kode_obat as kode",
        )
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
        $dtlistobat =  ListDaftarObat::where('kode_pasien', $dtpasien->pasien_kode)->get();
        $dtlisttindakan =  ListDaftarTindakan::where('kode_pasien', $dtpasien->pasien_kode)->get();
        $dtdiagnosa = PendaftaranPasien::where('pasien_id', $dtpasien->pasien_id)->orderBy('kode_pendaftaran', 'desc')->first();
        $dtriwayat = PendaftaranPasien::where('pasien_id', $dtpasien->pasien_id)->where('status_pemeriksaan', 'Tertangani')->with('poli')->get();
        $diagnosa = PendaftaranPasien::get();

        return view('listdaftarpasien.detailpasien', compact('dtpasien', 'dtlistobat', 'dtlisttindakan', 'dtdiagnosa', 'dtriwayat', 'diagnosa'));
    }


    public function insertlist(Request $request)
    {
        $dataobat = DataObat::where('nama_obat', $request->search)->with('kategori')->first();
        $dtpasien =  DataPasien::where('pasien_kode', $request->kode)->first();

        if ($dataobat && $dtpasien) {
            $listdaftarobat = ListDaftarObat::create([
                'nama_obat' => $dataobat->nama_obat,
                'kode_pasien' => $dtpasien->pasien_kode,
                'kategori_obat' => $dataobat->kategori->nama_kategori,
                'qty' => 1
            ]);

            $description_data = [
                'nama_obat' => $dataobat->nama_obat,
                'kode_pasien' => $dtpasien->pasien_kode,
                'kategori_obat' => $dataobat->kategori->nama_kategori,
                'qty' => 1,
                'list_id' => $listdaftarobat->id,
            ];

            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Disimpan!',
                'data' => $description_data
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Obat atau Pasien tidak ditemukan.',
                'data' => null
            ]);
        }
    }

    public function updatelist(Request $request)
    {
        $updatedData = [
            'qty' => $request->qty,
        ];

        ListDaftarObat::where('list_id', $request->list_id)->update($updatedData);

        $responseData = [
            'success' => true,
            'message' => 'Data Berhasil Diubah!',
            'data' => $updatedData
        ];

        return response()->json($responseData);
    }

    public function destroylist($list_id)
    {
        $listobat = ListDaftarObat::where('list_id', $list_id);
        $listobat->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
            'data' => $listobat,
        ]);
    }

    public function autocomplete_tindakan(Request $request)
    {
        $data = DataTindakan::select("nama_tindakan as label")
            ->where('nama_tindakan', 'LIKE', '%' . $request->get('cari') . '%')
            ->get();

        return response()->json($data);
    }

    public function inserttindakan(Request $request)
    {
        $datatindakan = DataTindakan::where('nama_tindakan', $request->search)->first();
        $dtpasien =  DataPasien::where('pasien_kode', $request->kode)->first();

        if ($datatindakan && $dtpasien) {
            $listdaftartindakan = ListDaftarTindakan::create([
                'nama_tindakan' => $datatindakan->nama_tindakan,
                'kode_pasien' => $dtpasien->pasien_kode,
                'harga_tindakan' => $datatindakan->harga_tindakan,
            ]);

            $description_data = [
                'nama_tindakan' => $datatindakan->nama_tindakan,
                'kode_pasien' => $dtpasien->pasien_kode,
                'harga_tindakan' => $datatindakan->harga_tindakan,
                'list_id' => $listdaftartindakan->id,
            ];

            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Disimpan!',
                'data' => $description_data
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Obat atau Pasien tidak ditemukan.',
                'data' => null
            ]);
        }
    }

    public function destroytindakan($list_id)
    {
        $listtindakan = ListDaftarTindakan::where('list_id', $list_id);
        $listtindakan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
            'data' => $listtindakan,
        ]);
    }

    public function updateDiagnosa(Request $request, $id)
    {
        $daftarTindakanExists = ListDaftarTindakan::where('kode_pasien', $request->kode)->exists();

        if ($daftarTindakanExists) {
            $updatedData = [
                'diagnosa' => $request->diagnosa,
                'status_pemeriksaan' => 'Tertangani',
            ];

            PendaftaranPasien::where('kode_pendaftaran', $id)->update($updatedData);
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Data gagal disimpan karena tidak ada daftar tindakan.']);
        }
    }

    public function detailriwayat($id)
    {
        $riwayat = PendaftaranPasien::find($id);
        return view('listdaftarpasien.detailpasien', compact('riwayat'));
    }
}
