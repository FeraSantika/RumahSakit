<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\DataObat;
use App\Models\kategori;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index()
    {
        $dtobat = DataObat::with('kategori')->paginate(10);
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('obat.obat', compact('dtobat', 'menu', 'roleuser'));
    }

    public function create()
    {
        $dtkategori = kategori::get();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('obat.create', compact('dtkategori', 'menu', 'roleuser'));
    }

    public function store(Request $request)
    {
        Dataobat::create([
            'nama_obat' => $request->nama,
            'kode_kategori' => $request->kategori,
            'harga_jual' => $request->hargajual,
            'diskon_obat' => $request->diskon,
            'stok_obat' => $request->stok,
        ]);
        return redirect()->route('obat');
    }

    public function edit($kode_obat)
    {
        $dtkategori = kategori::get();
        $dtobat = Dataobat::where('kode_obat', $kode_obat)->get();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('obat.edit', compact('dtobat', 'dtkategori', 'menu', 'roleuser'));
    }

    public function update(Request $request, $kode_obat)
    {
        Dataobat::where('kode_obat', $kode_obat)->update([
            'nama_obat' => $request->nama,
            'kode_kategori' => $request->kategori,
            'harga_jual' => $request->hargajual,
            'diskon_obat' => $request->diskon,
            'stok_obat' => $request->stok,
        ]);
        return redirect()->route('obat');
    }

    public function destroy($id)
    {
        Dataobat::where('kode_obat', $id)->delete();
        return redirect()->route('obat');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->get('cari');

        $data = DataObat::where('nama_obat', 'LIKE', '%' . $searchTerm . '%')
            ->with('kategori')->get();

        return response()->json($data);
    }
}
