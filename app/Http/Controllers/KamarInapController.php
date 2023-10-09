<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\DataKamarInap;

class KamarInapController extends Controller
{
    public function index(){
        $kamarinap = DataKamarInap::get();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('kamarinap.kamarinap', compact('kamarinap', 'menu', 'roleuser'));
    }

    public function create()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('kamarinap.create', compact('menu', 'roleuser'));
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
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('kamarinap.edit', compact('dtkamar', 'menu', 'roleuser'));
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
