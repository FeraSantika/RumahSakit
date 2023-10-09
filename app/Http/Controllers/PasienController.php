<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\DataObat;
use App\Models\kategori;
use App\Models\DataPasien;
use App\Models\DataRoleMenu;
use App\Models\DataTindakan;
use Illuminate\Http\Request;
use App\Models\ListDaftarObat;
use App\Models\PendaftaranPasien;
use App\Models\ListDaftarTindakan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PasienController extends Controller
{
    public function index()
    {
        $dtpasien =  DataPasien::paginate(10);
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('pasien.pasien', compact('dtpasien', 'menu', 'roleuser'));
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
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('pasien.create', compact('dtpasien', 'lastpasien', 'pasienCode', 'menu', 'roleuser'));
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
            'pasien_jenis_kelamin' => $request->jenis_kelamin,
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
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('pasien.edit', compact('dtpasien', 'menu', 'roleuser'));
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

    public function destroysearch($id)
    {
        try {
            $dt = DataPasien::where('pasien_id', $id);

            if ($dt) {
                $dt->delete();
                return response()->json(['message' => 'Pasien deleted successfully']);
            } else {
                return response()->json(['message' => 'Pasien not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting pasien: ' . $e->getMessage()], 500);
        }
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
        $dtpasien =  DataPasien::where('pasien_id', $id)->with('daftar')->first();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('pasien.detailpasien', compact('dtpasien', 'menu', 'roleuser'));
    }

    // public function insertlist(Request $request)
    // {
    //     $dataobat = DataObat::where('nama_obat', $request->search)->with('kategori')->first();
    //     $dtpasien =  DataPasien::where('pasien_kode', $request->kode)->first();

    //     if ($dataobat && $dtpasien) {
    //         $listdaftarobat = ListDaftarObat::create([
    //             'nama_obat' => $dataobat->nama_obat,
    //             'kode_pasien' => $dtpasien->pasien_kode,
    //             'kategori_obat' => $dataobat->kategori->nama_kategori,
    //             'qty' => 1
    //         ]);

    //         $description_data = [
    //             'nama_obat' => $dataobat->nama_obat,
    //             'kode_pasien' => $dtpasien->pasien_kode,
    //             'kategori_obat' => $dataobat->kategori->nama_kategori,
    //             'qty' => 1,
    //             'list_id' => $listdaftarobat->id,
    //         ];

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Data Berhasil Disimpan!',
    //             'data' => $description_data
    //         ]);
    //     } else {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Data Obat atau Pasien tidak ditemukan.',
    //             'data' => null
    //         ]);
    //     }
    // }

    // public function updatelist(Request $request)
    // {
    //     $updatedData = [
    //         'qty' => $request->qty,
    //     ];

    //     ListDaftarObat::where('list_id', $request->list_id)->update($updatedData);

    //     $responseData = [
    //         'success' => true,
    //         'message' => 'Data Berhasil Diubah!',
    //         'data' => $updatedData
    //     ];

    //     return response()->json($responseData);
    // }

    // public function destroylist($list_id)
    // {
    //     $listobat = ListDaftarObat::where('list_id', $list_id);
    //     $listobat->delete();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Data Berhasil Dihapus!.',
    //         'data' => $listobat,
    //     ]);
    // }

    // public function autocomplete_tindakan(Request $request)
    // {
    //     $data = DataTindakan::select("nama_tindakan as label")
    //         ->where('nama_tindakan', 'LIKE', '%' . $request->get('cari') . '%')
    //         ->get();

    //     return response()->json($data);
    // }

    // public function inserttindakan(Request $request)
    // {
    //     $datatindakan = DataTindakan::where('nama_tindakan', $request->search)->first();
    //     $dtpasien =  DataPasien::where('pasien_kode', $request->kode)->first();

    //     if ($datatindakan && $dtpasien) {
    //         $listdaftartindakan = ListDaftarTindakan::create([
    //             'nama_tindakan' => $datatindakan->nama_tindakan,
    //             'kode_pasien' => $dtpasien->pasien_kode,
    //             'harga_tindakan' => $datatindakan->harga_tindakan,
    //         ]);

    //         $description_data = [
    //             'nama_tindakan' => $datatindakan->nama_tindakan,
    //             'kode_pasien' => $dtpasien->pasien_kode,
    //             'harga_tindakan' => $datatindakan->harga_tindakan,
    //             'list_id' => $listdaftartindakan->id,
    //         ];

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Data Berhasil Disimpan!',
    //             'data' => $description_data
    //         ]);
    //     } else {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Data Obat atau Pasien tidak ditemukan.',
    //             'data' => null
    //         ]);
    //     }
    // }

    // public function destroytindakan($list_id)
    // {
    //     $listtindakan = ListDaftarTindakan::where('list_id', $list_id);
    //     $listtindakan->delete();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Data Berhasil Dihapus!.',
    //         'data' => $listtindakan,
    //     ]);
    // }

    // public function updateDiagnosa(Request $request, $id)
    // {
    //     $data = PendaftaranPasien::findOrFail($id);

    //     $data->diagnosa = $request->diagnosa;
    //     $data->save();

    //     return redirect()->route('pasien');
    // }
}
