<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\kategori;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $dtkategori = kategori::paginate(10);
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('kategori.kategori', compact('dtkategori', 'menu', 'roleuser'));
    }

    public function create()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('kategori.create', compact('menu', 'roleuser'));
    }

    public function store(Request $request)
    {
        kategori::create([
            'nama_kategori' => $request->nama,
        ]);
        return redirect()->route('kategori');
    }

    public function edit($kode_kategori)
    {
        $dtkategori = kategori::where('kode_kategori', $kode_kategori)->first();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('kategori.edit', compact('dtkategori', 'menu', 'roleuser'));
    }

    public function update(Request $request, $kode_kategori)
    {
        kategori::where('kode_kategori', $kode_kategori)->update(['nama_kategori' => $request->nama]);
        return redirect()->route('kategori');
    }

    public function destroy($kode_kategori)
    {
        kategori::where('kode_kategori', $kode_kategori)->delete();
        return redirect()->route('kategori');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->get('cari');

        $data = kategori::where('nama_kategori', 'LIKE', '%' . $searchTerm . '%')
            ->get();

        return response()->json($data);
    }
}
