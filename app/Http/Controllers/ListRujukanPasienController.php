<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\DataAksesLab;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\DataTindakanLab;
use App\Models\ListDaftarRujukan;
use App\Models\PendaftaranPasien;
use Illuminate\Support\Facades\Auth;

class ListRujukanPasienController extends Controller
{
    public function index()
    {
        $user = Auth::user()->User_id;
        $akses = DataAksesLab::where('id_user', $user)->first();
        $dtpendaftar = ListDaftarRujukan::where('id_lab', $akses->id_lab)->with(['daftar.user', 'lab'])->paginate(10);

        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('listrujukanrawatjalan.listrujukanpasien', compact('dtpendaftar', 'menu', 'roleuser'));
    }

    public function detail($id)
    {
        $pendaftar = ListDaftarRujukan::where('list_id', $id)->first();
        $pasien_id = $pendaftar->daftar->pasien->pasien_id;
        $dtriwayat = PendaftaranPasien::where('pasien_id', $pasien_id)->where('status_pemeriksaan', 'Tertangani')->with('user', 'listobat', 'listtindakan', 'listrujukan.lab')->get();
        $dtlistrujukan = ListDaftarRujukan::where('list_id', $id)->with('lab')->get();
        $rujukan = ListDaftarRujukan::where('kode_pendaftaran', $id)->first();

        $tindakanlab = [];
        foreach ($dtlistrujukan as $rujukan) {
            $id_lab = $rujukan->lab->id_lab;
            $tindakanlab[] = DataTindakanLab::where('id_lab', $id_lab)->get();
        }

        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        return view('listrujukanrawatjalan.detailrujukanpasien', compact(
            'pendaftar',
            'dtriwayat',
            'menu',
            'roleuser',
            'tindakanlab',
            'rujukan'
        ));
    }

    public function uploadfile(Request $request, $id)
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

        ListDaftarRujukan::where('list_id', $id)->update($userData);
        return redirect()->route('list-rujukan-pasienJalan');
    }
}
