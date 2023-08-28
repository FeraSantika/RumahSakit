<?php

namespace App\Http\Controllers;

use App\Models\DataObat;
use App\Models\kategori;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index()
    {
        $dtobat = DataObat::with('kategori')->paginate(10);
        return view('obat.obat', compact('dtobat'));
    }

    public function create()
    {
        $dtkategori = kategori::get();
        return view('obat.create', compact('dtkategori'));
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
        return view('obat.edit', compact('dtobat', 'dtkategori'));
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
