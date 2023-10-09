<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\DataAksesLab;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\DataTindakanLab;
use Illuminate\Support\Facades\Auth;
use App\Models\PendaftaranPasienInap;
use App\Models\ListDaftarRujukanPasienInap;

class ListRujukanPasienInapController extends Controller
{
    public function index()
    {
        $user = Auth::user()->User_id;
        $akses = DataAksesLab::where('id_user', $user)->first();
        $dtpendaftar = ListDaftarRujukanPasienInap::where('id_lab', $akses->id_lab)->with(['daftar.user', 'lab'])->paginate(10);

        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('listrujukanrawatinap.listrujukanpasien', compact('dtpendaftar', 'menu', 'roleuser'));
    }

    public function detail($id)
    {
        $pendaftar = ListDaftarRujukanPasienInap::where('list_id', $id)->with('daftar.pasien')->first();
        $pasien_id = $pendaftar->daftar->pasien->pasien_id;
        $dtriwayat = PendaftaranPasienInap::where('pasien_id', $pasien_id)->where('status_pemeriksaan', 'Tertangani')
            ->with( 'user', 'listobat', 'listtindakan', 'listrujukan.lab')->get();
        $dtlistrujukan = ListDaftarRujukanPasienInap::where('list_id', $id)->with('lab')->get();
        $rujukan = ListDaftarRujukanPasienInap::where('kode_pendaftaran', $id)->first();

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

        ListDaftarRujukanPasienInap::where('list_id', $id)->update($userData);
        return redirect()->route('list-rujukan-pasienInap');
    }
}
