<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\DataPoli;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    public function index()
    {
        $poli = DataPoli::all();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('poli.poli', compact('poli', 'menu', 'roleuser'));
    }

    public function create()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('poli.create', compact('menu', 'roleuser'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        DataPoli::create([
            'nama_poli' => $request->nama,
            'kode_poli' => $request->kode,
        ]);

        return redirect()->route('poli');
    }

    public function edit($id)
    {
        $poli = DataPoli::where('id_poli', $id)->first();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('poli.edit', compact('poli', 'menu', 'roleuser'));
    }

    public function update(Request $request, $id)
    {
        $poli = [
            'nama_poli' => $request->nama,
            'kode_poli' => $request->kode,
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
