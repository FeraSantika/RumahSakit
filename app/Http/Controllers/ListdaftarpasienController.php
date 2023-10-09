<?php

namespace App\Http\Controllers;

use file;
use App\Models\DataLab;
use App\Models\DataMenu;
use App\Models\DataObat;
use App\Models\DataPasien;
use PharIo\Manifest\Author;
use App\Models\DataRoleMenu;
use App\Models\DataTindakan;
use Illuminate\Http\Request;
use App\Models\DataAksesPoli;
use App\Models\ListDaftarObat;
use App\Models\ListDaftarRujukan;
use App\Models\PendaftaranPasien;
use App\Models\ListDaftarTindakan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\DataTindakanLab;

class ListdaftarpasienController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $akses = $user->poliakses;

        if ($user->Role_id == 1) {
            $dtpendaftar = PendaftaranPasien::with(['aksespoli.user'])
                ->paginate(10);
        } else {
            $dtpendaftar = PendaftaranPasien::with(['aksespoli.user'])
                ->whereHas('aksespoli.user', function ($query) use ($user) {
                    $query->where('User_id', $user->User_id);
                })->paginate(10);
        }

        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('listpasienrawatjalan.listdaftarpasien', compact('dtpendaftar', 'menu', 'roleuser'));
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
        $user = Auth::user();
        $searchTerm = $request->get('cari');

        $data = PendaftaranPasien::with(['aksespoli.user', 'pasien', 'poli'])
            ->whereHas('aksespoli.user', function ($query) use ($user) {
                $query->where('User_id', $user->User_id);
            })
            ->whereHas('pasien', function ($query) use ($searchTerm) {
                $query->where('pasien_nama', 'LIKE', '%' . $searchTerm . '%');
                $query->orWhere('kode_pendaftaran', 'LIKE', '%' . $searchTerm . '%');
            })

            ->get();

        return response()->json($data);
    }


    public function detail($id)
    {
        $dtpendaftar = PendaftaranPasien::where('kode_pendaftaran', $id)->with('pasien')->get();
        $dtlistobat =  ListDaftarObat::where('kode_pendaftaran', $id)->get();
        $dtlisttindakan =  ListDaftarTindakan::where('kode_pendaftaran', $id)->get();
        $dtlistrujukan = ListDaftarRujukan::where('kode_pendaftaran', $id)->get();
        $rujukan = ListDaftarRujukan::where('kode_pendaftaran', $id)->first();

        foreach ($dtpendaftar as $pendaftaran) {
            $pasien_id = $pendaftaran->pasien_id;
            $dtriwayat = PendaftaranPasien::where('pasien_id', $pasien_id)->where('status_pemeriksaan', 'Tertangani')->with('poli', 'user', 'listobat', 'listtindakan', 'listrujukan.lab')->get();
        }
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('listpasienrawatjalan.detailpasien', compact(
            'dtpendaftar',
            'dtriwayat',
            'dtlistobat',
            'dtlisttindakan',
            'menu',
            'roleuser',
            'dtlistrujukan',
            'rujukan'
        ));
    }

    public function insertlist(Request $request)
    {
        $dataobat = DataObat::where('nama_obat', $request->search)->with('kategori')->first();
        $dtpasien =  PendaftaranPasien::where('kode_pendaftaran', $request->kode)->first();

        if ($dataobat && $dtpasien) {
            $listdaftarobat = ListDaftarObat::create([
                'nama_obat' => $dataobat->nama_obat,
                'kode_pendaftaran' => $dtpasien->kode_pendaftaran,
                'kategori_obat' => $dataobat->kategori->nama_kategori,
                'qty' => 1
            ]);

            $description_data = [
                'nama_obat' => $dataobat->nama_obat,
                'kode_pendaftaran' => $dtpasien->kode_pendaftaran,
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
        $dtpasien =  PendaftaranPasien::where('kode_pendaftaran', $request->kode)->first();

        if ($datatindakan && $dtpasien) {
            $listdaftartindakan = ListDaftarTindakan::create([
                'nama_tindakan' => $datatindakan->nama_tindakan,
                'kode_pendaftaran' => $dtpasien->kode_pendaftaran,
                'harga_tindakan' => $datatindakan->harga_tindakan,
            ]);

            $description_data = [
                'nama_tindakan' => $datatindakan->nama_tindakan,
                'kode_pendaftaran' => $dtpasien->kode_pendaftaran,
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
        $user = Auth::user();
        $updatedData = [
            'diagnosa' => $request->diagnosa,
            'status_pemeriksaan' => 'Tertangani',
            'petugas' => $user->User_id
        ];

        PendaftaranPasien::where('kode_pendaftaran', $id)->update($updatedData);
        return response()->json(['success' => true]);
    }

    public function autocomplete_rujukan(Request $request)
    {
        $data = DataLab::select("nama_lab as label", "id_lab as value")
            ->where('nama_lab', 'LIKE', '%' . $request->get('cari') . '%')
            ->get();

        return response()->json($data);
    }

    public function insertrujukan(Request $request)
    {
        $datarujukan = DataLab::where('id_lab', $request->search)->first();
        $dtpasien =  PendaftaranPasien::where('kode_pendaftaran', $request->kode)->first();
        $rujukanpasien = ListDaftarRujukan::where('kode_pendaftaran', $request->kode)->first();

        if ($datarujukan && $dtpasien) {
            $listdaftarrujukan = ListDaftarRujukan::create([
                'id_lab' => $datarujukan->id_lab,
                'kode_pendaftaran' => $dtpasien->kode_pendaftaran,
            ]);

            $description_data = [
                'id_lab' => $datarujukan->id_lab,
                'kode_pendaftaran' => $dtpasien->kode_pendaftaran,
                'list_id' => $listdaftarrujukan->id,
                'nama_lab' => $datarujukan->nama_lab,
                'keterangan' => $rujukanpasien->keterangan,
                'file' => $rujukanpasien->filerujukan,
                'status' => $rujukanpasien->status
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

    public function destroyrujukan($list_id)
    {
        $listrujukan = ListDaftarRujukan::where('list_id', $list_id);
        $listrujukan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
            'data' => $listrujukan,
        ]);
    }

    // public function pasienrujukan()
    // {
    //     $user = Auth::user();
    //     $akses = $user->poliakses;
    //     $dtpendaftar = ListDaftarRujukan::with(['daftar.user', 'lab'])->paginate(10);

    //     $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
    //     $user = auth()->user()->role;
    //     $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
    //     return view('listrujukanrawatjalan.listrujukanpasien', compact('dtpendaftar', 'menu', 'roleuser'));
    // }

    // public function detailpasienrujukan($id)
    // {
    //     $pendaftar = ListDaftarRujukan::where('list_id', $id)->first();
    //     $pasien_id = $pendaftar->daftar->pasien->pasien_id;
    //     $dtriwayat = PendaftaranPasien::where('pasien_id', $pasien_id)->where('status_pemeriksaan', 'Tertangani')->with('user', 'listobat', 'listtindakan')->get();
    //     $dtlistrujukan = ListDaftarRujukan::where('list_id', $id)->with('lab')->get();

    //     $tindakanlab = [];
    //     foreach ($dtlistrujukan as $rujukan) {
    //         $id_lab = $rujukan->lab->id_lab;
    //         $tindakanlab[] = DataTindakanLab::where('id_lab', $id_lab)->get();
    //     }

    //     $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
    //     $user = auth()->user()->role;
    //     $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
    //     return view('listrujukanrawatjalan.detailrujukanpasien', compact(
    //         'pendaftar',
    //         'dtriwayat',
    //         'menu',
    //         'roleuser',
    //         'tindakanlab'
    //     ));
    // }

    // public function uploadfilerujukan(Request $request, $id)
    // {
    //     $request->validate([
    //         'keterangan' => 'required|string',
    //         'file' => 'file|max:5120',
    //         'tindakan' => 'required'
    //     ]);

    //     if ($request->hasFile('file')) {
    //         $file = $request->file('file');
    //         $extension = $file->getClientOriginalExtension();

    //         if (in_array(strtolower($extension), ['php', 'html'])) {
    //             return redirect()->back()->with('error', 'File dengan ekstensi .php atau .html tidak diizinkan.');
    //         }

    //         $destinationPath = 'uploads/';
    //         $filename = 'rujukan' . date('YmdHis') . "." . $extension;

    //         $file->move($destinationPath, $filename);
    //     }

    //     $userData = [
    //         'tindakan' => $request->tindakan,
    //         'keterangan' => $request->keterangan,
    //         'filerujukan' => $filename,
    //         'status' => 'Tertangani'
    //     ];

    //     ListDaftarRujukan::where('list_id', $id)->update($userData);
    //     return redirect()->route('list-rujukan-pasienJalan');
    // }
}
