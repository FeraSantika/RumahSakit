<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataKamarInap;

class KamarInapController extends Controller
{
    public function index(){
        $kamarinap = DataKamarInap::get();
        return view('kamarinap.kamarinap', compact('kamarinap'));
    }

    public function create()
    {
        return view('kamarinap.create');
    }

    public function store(Request $request)
    {
        DataKamarInap::create([
            'nama_kamar_inap' => $request->nama,
            'nomor_kamar_inap' => $request->nomor,
            'harga_kamar_inap' => $request->harga,
        ]);

        return redirect()->route('kamar_inap');
    }

    public function edit($id)
    {
        $dtkamar = DataKamarInap::where('id_kamar_inap', $id)->first();
        return view('kamarinap.edit', compact('dtkamar'));
    }

    public function update(Request $request, $id)
    {
        $poli = [
            'nama_kamar_inap' => $request->nama,
            'nomor_kamar_inap' => $request->nomor,
            'harga_kamar_inap' => $request->harga,
        ];

        DataKamarInap::where('id_kamar_inap', $id)->update($poli);
        return redirect()->route('kamar_inap');
    }

    public function destroy($id)
    {
        $dtkamar = DataKamarInap::where('id_kamar_inap', $id);
        $dtkamar->delete();
        return redirect()->route('kamar_inap');
    }
}
