<?php

namespace App\Http\Controllers;

use App\Models\DataTindakan;
use Illuminate\Http\Request;

class TindakanController extends Controller
{
    public function index()
    {
        $dttindakan = DataTindakan::paginate(10);
        return view('tindakan.tindakan', compact('dttindakan'));
    }

    public function create()
    {
        return view('tindakan.create');
    }

    public function store(Request $request)
    {
        DataTindakan::create([
            'nama_tindakan' => $request->nama,
            'harga_tindakan' => $request->harga
        ]);

        return redirect()->route('tindakan');
    }

    public function edit($id)
    {
        $dttindakan = DataTindakan::where('id_tindakan', $id)->first();
        return view('tindakan.edit', compact('dttindakan'));
    }

    public function update(Request $request, $id_tindakan)
    {
        DataTindakan::where('id_tindakan', $id_tindakan)->update([
            'nama_tindakan' => $request->nama,
            'harga_tindakan' => $request->harga,
        ]);

        return redirect()->route('tindakan');
    }

    public function destroy($id_tindakan)
    {
        DataTindakan::where('id_tindakan', $id_tindakan)->delete();

        return redirect()->route('tindakan');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->get('cari');

        $data = DataTindakan::where('nama_tindakan', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('harga_tindakan', 'LIKE', '%' . $request->get('cari') . '%')
            ->get();

        return response()->json($data);
    }
}
