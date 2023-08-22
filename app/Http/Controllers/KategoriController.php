<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $dtkategori = kategori::get();
        return view('kategori.kategori', compact('dtkategori'));
    }

    public function create()
    {
        return view('kategori.create');
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
        return view('kategori.edit', compact('dtkategori'));
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
}
