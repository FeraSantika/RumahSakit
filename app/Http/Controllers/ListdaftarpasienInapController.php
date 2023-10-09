<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\DataLab;
use App\Models\DataMenu;
use App\Models\DataObat;
use App\Models\DataPasien;
use App\Models\DataRoleMenu;
use App\Models\DataTindakan;
use Illuminate\Http\Request;
use App\Models\DataKamarInap;
use App\Models\ListDaftarObat;
use App\Models\DataTindakanLab;
use App\Models\KamarPasienInap;
use App\Models\DiagnosaPasienInap;
use App\Models\ListDaftarTindakan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\PendaftaranPasienInap;
use App\Models\ListDaftarObatPasienInap;
use App\Models\ListDaftarRujukanPasienInap;
use App\Models\ListDaftarTindakanPasienInap;

class ListdaftarpasienInapController extends Controller
{
    public function index()
    {
        $dokter = Auth::user()->User_name;
        $dtpendaftar = PendaftaranPasienInap::paginate(10);
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('listpasienrawatinap.listdaftarpasien', compact('dtpendaftar', 'dokter', 'menu', 'roleuser'));
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
        $dokter = Auth::user()->User_name;
        $searchTerm = $request->get('cari');

        $responsedata = PendaftaranPasienInap::with('pasien')->whereHas('pasien', function ($query) use ($searchTerm) {
            $query->where('pasien_nama', 'LIKE', '%' . $searchTerm . '%');
            $query->orWhere('kode_pendaftaran', 'LIKE', '%' . $searchTerm . '%');
        })

            ->get();

        $data = [
            'dokter' => $dokter,
            'data' => $responsedata,
        ];

        return response()->json($data);
    }

    public function detail($id)
    {
        $dtpendaftar = PendaftaranPasienInap::where('kode_pendaftaran', $id)->with('pasien')->get();
        $dtlistobat =  ListDaftarObatPasienInap::where('kode_pendaftaran', $id)->get();
        $dtlisttindakan =  ListDaftarTindakanPasienInap::where('kode_pendaftaran', $id)->get();
        $dtkamar =  DataKamarInap::get();
        $dtkamarpasien = KamarPasienInap::where('kode_pendaftaran', $id)->with('kamar')->get();
        $editkamarpasien = KamarPasienInap::where('kode_pendaftaran', $id)->with('kamar')->first();
        $dtdiagnosa = DiagnosaPasienInap::where('kode_pendaftaran', $id)->get();
        $editdiagnosa = DiagnosaPasienInap::where('kode_pendaftaran', $id)->first();
        $dtlistrujukan = ListDaftarRujukanPasienInap::where('kode_pendaftaran', $id)->get();
        $rujukan = ListDaftarRujukanPasienInap::where('kode_pendaftaran', $id)->first();

        foreach ($dtpendaftar as $pendaftaran) {
            $pasien_id = $pendaftaran->pasien_id;
            $dtriwayat = PendaftaranPasienInap::where('pasien_id', $pasien_id)->where('status_pemeriksaan', 'Tertangani')->with('user', 'listobat', 'listtindakan')->get();
        }
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('listpasienrawatinap.detailpasien', compact(
            'dtpendaftar',
            'dtriwayat',
            'dtlistobat',
            'dtlisttindakan',
            'dtkamarpasien',
            'editkamarpasien',
            'dtdiagnosa',
            'editdiagnosa',
            'menu',
            'roleuser',
            'dtlistrujukan',
            'rujukan'
        ));
    }

    public function insertlistobat(Request $request)
    {
        $dataobat = DataObat::where('nama_obat', $request->search)->with('kategori')->first();
        $dtpasien =  PendaftaranPasienInap::where('kode_pendaftaran', $request->kode)->first();

        if ($dataobat && $dtpasien) {
            $listdaftarobat = ListDaftarObatPasienInap::create([
                'nama_obat' => $dataobat->nama_obat,
                'tanggal' => $request->tglobat,
                'kode_pendaftaran' => $dtpasien->kode_pendaftaran,
                'kategori_obat' => $dataobat->kategori->nama_kategori,
                'qty' => 1
            ]);

            $description_data = [
                'nama_obat' => $dataobat->nama_obat,
                'tanggal' => $request->tglobat,
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

    public function updatelistobat(Request $request)
    {
        $updatedData = [
            'qty' => $request->qty,
        ];

        ListDaftarObatPasienInap::where('list_id', $request->list_id)->update($updatedData);

        $responseData = [
            'success' => true,
            'message' => 'Data Berhasil Diubah!',
            'data' => $updatedData
        ];

        return response()->json($responseData);
    }

    public function destroylist($list_id)
    {
        $listobat = ListDaftarObatPasienInap::where('list_id', $list_id);
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

    public function autocomplete_kamar(Request $request)
    {
        $data = DataKamarInap::select("nama_kamar_inap as nama", "nomor_kamar_inap as nomor", "id_kamar_inap as id")
            ->where('nama_kamar_inap', 'LIKE', '%' . $request->get('cari') . '%')
            ->get();

        return response()->json($data);
    }

    public function inserttindakan(Request $request)
    {
        $datatindakan = DataTindakan::where('nama_tindakan', $request->search)->first();
        $dtpasien =  PendaftaranPasienInap::where('kode_pendaftaran', $request->kode)->first();

        if ($datatindakan && $dtpasien) {
            $listdaftartindakan = ListDaftarTindakanPasienInap::create([
                'nama_tindakan' => $datatindakan->nama_tindakan,
                'tanggal' => $request->tgltindakan,
                'kode_pendaftaran' => $dtpasien->kode_pendaftaran,
                'harga_tindakan' => $datatindakan->harga_tindakan,
            ]);

            $description_data = [
                'nama_tindakan' => $datatindakan->nama_tindakan,
                'tanggal' => $request->tgltindakan,
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

    public function updatetindakan(Request $request)
    {
        $datatindakan = DataTindakan::where('nama_tindakan', $request->search)->first();

        $updatedData = [
            'nama_tindakan' => $datatindakan->nama_tindakan,
            'tanggal' => $request->tgltindakan,
            'harga_tindakan' => $datatindakan->harga_tindakan,
            'list_id' => $request->list_id
        ];

        ListDaftarTindakanPasienInap::where('list_id', $request->list_id)->update($updatedData);

        $responseData = [
            'success' => true,
            'message' => 'Data Berhasil Diubah!',
            'data' => $updatedData,
        ];

        return response()->json($responseData);
    }

    public function destroytindakan($list_id)
    {
        $listtindakan = ListDaftarTindakanPasienInap::where('list_id', $list_id);
        $listtindakan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
            'data' => $listtindakan,
        ]);
    }

    public function insertkamarpasien(Request $request)
    {
        $kamarpasien = KamarPasienInap::create([
            'tanggal_masuk' => $request->tglmasuk,
            'tanggal_keluar' => $request->perkiraankeluar,
            'id_kamar_inap' => $request->id,
            'kode_pendaftaran' => $request->kode
        ]);

        $responseData = KamarPasienInap::with('kamar')->where('id_kamar_inap', $request->id)->first();

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data' => $responseData,
        ]);
    }

    public function updatekamarpasien(Request $request)
    {
        $updatedData = [
            'tanggal_masuk' => $request->tglmasuk,
            'tanggal_keluar' => $request->perkiraankeluar,
            'id_kamar_inap' => $request->idkamar,
            'kode_pendaftaran' => $request->kode,
        ];

        KamarPasienInap::where('id_kamar_pasieninap', $request->id)->update($updatedData);

        $updatedData = KamarPasienInap::with('kamar')->where('id_kamar_pasieninap', $request->id)->first();

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data' => $updatedData,
        ]);
    }


    public function destroykamarpasien($id)
    {
        $kamarinap = KamarPasienInap::where('id_kamar_pasieninap', $id);
        $kamarinap->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
            'data' => $kamarinap,
        ]);
    }

    public function insertdiagnosapasien(Request $request)
    {
        $responseData = DiagnosaPasienInap::create([
            'tanggal' => $request->tgldiagnosa,
            'diagnosa' => $request->diagnosa,
            'kode_pendaftaran' => $request->kode
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data' => $responseData,
        ]);
    }

    public function updatediagnosapasien(Request $request)
    {
        $updatedData = [
            'tanggal' => $request->tgldiagnosa,
            'diagnosa' => $request->diagnosa,
        ];

        DiagnosaPasienInap::where('id_diagnosa_pasieninap', $request->id)->update($updatedData);
        $updatedData = DiagnosaPasienInap::where('id_diagnosa_pasieninap', $request->id)->first();
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data' => $updatedData,
        ]);
    }

    public function destroydiagnosapasien($id)
    {
        $diagnosa = DiagnosaPasienInap::where('id_diagnosa_pasieninap', $id);
        $diagnosa->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
            'data' => $diagnosa,
        ]);
    }

    public function statuspemeriksaanupdate(Request $request)
    {
        $user = Auth::user();
        $updatedData = [
            'status_pemeriksaan' => $request->pemeriksaan,
            'petugas' => $user->User_id
        ];

        PendaftaranPasienInap::where('kode_pendaftaran', $request->kode)->update($updatedData);

        $responseData = [
            'success' => true,
            'message' => 'Data Berhasil Diubah!',
            'data' => $updatedData
        ];

        return response()->json($responseData);
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
        $dtpasien =  PendaftaranPasienInap::where('kode_pendaftaran', $request->kode)->first();
        $rujukanpasien = ListDaftarRujukanPasienInap::where('kode_pendaftaran', $request->kode)->first();

        if ($datarujukan && $dtpasien) {
            $listdaftarrujukan = ListDaftarRujukanPasienInap::create([
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
        $listrujukan = ListDaftarRujukanPasienInap::where('list_id', $list_id);
        $listrujukan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
            'data' => $listrujukan,
        ]);
    }

    public function pasienrujukan()
    {
        $user = Auth::user();
        $akses = $user->poliakses;
        $dtpendaftar = ListDaftarRujukanPasienInap::with(['daftar.user', 'lab'])->paginate(10);

        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('listrujukanrawatinap.listrujukanpasien', compact('dtpendaftar', 'menu', 'roleuser'));
    }

    public function detailpasienrujukan($id)
    {
        $pendaftar = ListDaftarRujukanPasienInap::where('list_id', $id)->with('daftar.pasien')->first();
        $pasien_id = $pendaftar->daftar->pasien->pasien_id;
        $dtriwayat = PendaftaranPasienInap::where('pasien_id', $pasien_id)->where('status_pemeriksaan', 'Tertangani')
            ->with('poli', 'user', 'listobat', 'listtindakan')->get();
        $dtlistrujukan = ListDaftarRujukanPasienInap::where('list_id', $id)->with('lab')->get();
        $tindakanlab = [];
        foreach ($dtlistrujukan as $rujukan) {
            $id_lab = $rujukan->lab->id_lab;
            $tindakanlab[] = DataTindakanLab::where('id_lab', $id_lab)->get();
        }

        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('listrujukanrawatinap.detailrujukanpasien', compact(
            'menu',
            'roleuser',
            'pendaftar',
            'dtriwayat',
            'tindakanlab'
        ));
    }

    public function uploadfilerujukan(Request $request, $id)
    {
        $request->validate([
            'keterangan' => 'required|string',
            'file' => 'file|max:5120',
            'tindakan' => 'required'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();

            if (in_array(strtolower($extension), ['php', 'html'])) {
                return redirect()->back()->with('error', 'File dengan ekstensi .php atau .html tidak diizinkan.');
            }

            $destinationPath = 'uploads/';
            $filename = 'rujukan' . date('YmdHis') . "." . $extension;

            $file->move($destinationPath, $filename);
        }

        $userData = [
            'tindakan' => $request->tindakan,
            'keterangan' => $request->keterangan,
            'filerujukan' => $filename,
            'status' => 'Tertangani'
        ];

        ListDaftarRujukanPasienInap::where('list_id', $id)->update($userData);
        return redirect()->route('list-rujukan-pasienInap');
    }
}
