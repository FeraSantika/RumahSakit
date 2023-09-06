<?php

namespace App\Http\Controllers;

use App\Models\DataKamarInap;
use App\Models\DataObat;
use App\Models\DataPasien;
use App\Models\DataTindakan;
use App\Models\DiagnosaPasienInap;
use App\Models\KamarPasienInap;
use Illuminate\Http\Request;
use App\Models\ListDaftarObat;
use App\Models\ListDaftarTindakan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\PendaftaranPasienInap;
use App\Models\ListDaftarObatPasienInap;
use App\Models\ListDaftarTindakanPasienInap;
use Carbon\Carbon;

class ListdaftarpasienInapController extends Controller
{
    public function index()
    {
        $dokter = Auth::user()->User_name;
        $dtpendaftar = PendaftaranPasienInap::paginate(10);

        return view('listpasienrawatinap.listdaftarpasien', compact('dtpendaftar', 'dokter'));
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
        $dtpendaftar = PendaftaranPasienInap::where('kode_pendaftaran', $id)->with('pasien')->get();
        $dtlistobat =  ListDaftarObatPasienInap::where('kode_pendaftaran', $id)->get();
        $dtlisttindakan =  ListDaftarTindakanPasienInap::where('kode_pendaftaran', $id)->get();
        $dtkamar =  DataKamarInap::get();
        $dtkamarpasien = KamarPasienInap::where('kode_pendaftaran', $id)->with('kamar')->get();
        $editkamarpasien = KamarPasienInap::where('kode_pendaftaran', $id)->with('kamar')->first();
        $dtdiagnosa = DiagnosaPasienInap::where('kode_pendaftaran', $id)->get();
        $editdiagnosa = DiagnosaPasienInap::where('kode_pendaftaran', $id)->first();

        foreach ($dtpendaftar as $pendaftaran) {
            $pasien_id = $pendaftaran->pasien_id;
            $dtriwayat = PendaftaranPasienInap::where('pasien_id', $pasien_id)->where('status_pemeriksaan', 'Tertangani')->with('poli', 'user', 'listobat', 'listtindakan')->get();
        }
        return view('listpasienrawatinap.detailpasien', compact('dtpendaftar', 'dtriwayat', 'dtlistobat', 'dtlisttindakan', 'dtkamarpasien', 'editkamarpasien', 'dtdiagnosa', 'editdiagnosa'));
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

    public function updatelist(Request $request)
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

    // public function inserttindakan(Request $request)
    // {
    //     $datatindakan = DataTindakan::where('nama_tindakan', $request->search)->first();
    //     $dtpasien =  PendaftaranPasienInap::where('kode_pendaftaran', $request->kode)->first();

    //     if ($datatindakan && $dtpasien) {
    //         $listdaftartindakan = ListDaftarTindakanPasienInap::create([
    //             'nama_tindakan' => $datatindakan->nama_tindakan,
    //             'kode_pendaftaran' => $dtpasien->kode_pendaftaran,
    //             'harga_tindakan' => $datatindakan->harga_tindakan,
    //         ]);

    //         $description_data = [
    //             'nama_tindakan' => $datatindakan->nama_tindakan,
    //             'kode_pendaftaran' => $dtpasien->kode_pendaftaran,
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
    //     $listtindakan = ListDaftarTindakanPasienInap::where('list_id', $list_id);
    //     $listtindakan->delete();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Data Berhasil Dihapus!.',
    //         'data' => $listtindakan,
    //     ]);
    // }



    public function insertkamarpasien(Request $request)
    {
        $kamarpasien = KamarPasienInap::create([
            'tanggal_masuk' => $request->tglmasuk,
            'tanggal_keluar' => $request->perkiraankeluar,
            'id_kamar_inap' => $request->id,
            'kode_pendaftaran' => $request->kode
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data' => $kamarpasien,
        ]);
    }

    public function updatekamarpasien(Request $request)
    {
        $updatedData = [
            'tanggal_masuk' => $request->tglmasuk,
            'tanggal_keluar' => $request->perkiraankeluar,
            'id_kamar_inap' => $request->idkamar,
            'kode_pendaftaran' => $request->kode
        ];

        KamarPasienInap::where('id_kamar_pasieninap', $request->id)->update($updatedData);

        $responseData = [
            'success' => true,
            'message' => 'Data Berhasil Diubah!',
            'data' => $updatedData
        ];

        return response()->json($responseData);
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
        DiagnosaPasienInap::create([
            'tanggal' => $request->tgldiagnosa,
            'diagnosa' => $request->diagnosa,
            'kode_pendaftaran' => $request->kode
        ]);
        return redirect()->back()->with('success', 'Diagnosa berhasil ditambahkan.');
    }

    public function updatediagnosapasien(Request $request)
    {
        $diagnosaId = $request->input('edit-diagnosa-id');

        $diagnosa = DiagnosaPasienInap::find($diagnosaId);
        if (!$diagnosa) {
            return redirect()->back()->with('error', 'Diagnosa tidak ditemukan.');
        }

        $updatedData = [
            'tanggal' => $request->tgldiagnosa,
            'diagnosa' => $request->diagnosa,
        ];

        DiagnosaPasienInap::where('id_diagnosa_pasieninap', $diagnosaId)->update($updatedData);

        return redirect()->back()->with('success', 'Diagnosa berhasil diperbarui.');
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

    public function getObat()
    {
        $obat = DataObat::all();

        return response()->json([
            'data' => $obat,
        ]);
    }

    public function datakamar($id)
    {
        $dtkamarpasien = KamarPasienInap::where('kode_pendaftaran', $id)->with('kamar')->get();
        return response()->json($dtkamarpasien);
    }
}
