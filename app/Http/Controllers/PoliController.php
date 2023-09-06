<?php

namespace App\Http\Controllers;

use App\Models\DataPoli;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    public function index()
    {
        $poli = DataPoli::all();
        return view('poli.poli', compact('poli'));
    }

    public function create()
    {
        return view('poli.create');
    }

    public function store(Request $request)
    {
         $request->validate([
            'nama' => 'required',
        ]);

        DataPoli::create([
            'nama_poli' => $request->nama,
        ]);

        return redirect()->route('poli');
    }

    public function edit($id)
    {
        $poli = DataPoli::where('id_poli', $id)->first();
        return view('poli.edit', compact('poli'));
    }

    public function update(Request $request, $id)
    {
        $poli = [
            'nama_poli' => $request->nama,
        ];

        DataPoli::where('id_poli', $id)->update($poli);
        return redirect()->route('poli');
    }

    public function destroy($id)
    {
        $poli = DataPoli::where('id_poli', $id);
        $poli->delete();
        return redirect()->route('poli');
    }
}
