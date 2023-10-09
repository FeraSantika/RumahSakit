<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\DataPoli;
use App\Models\DataUser;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\DataAksesPoli;

class AksespoliController extends Controller
{
    public function index()
    {
        $dtaksespoli = DataAksesPoli::get();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('aksespoli.aksespoli', compact('dtaksespoli', 'menu', 'roleuser'));
    }

    public function create()
    {
        $dtuser = DataUser::get();
        $dtpoli = DataPoli::get();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('aksespoli.create', compact('dtuser', 'dtpoli', 'menu', 'roleuser'));
    }

    public function store(Request $request)
    {
        DataAksesPoli::create([
            'id_poli' => $request->poli,
            'id_user' => $request->user
        ]);

        return redirect()->route('akses-poli');
    }

    public function edit($id)
    {
        $dtuser = DataUser::get();
        $dtpoli = DataPoli::get();
        $dtaksespoli = DataAksesPoli::where('id_akses_poli', $id)->first();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('aksespoli.edit', compact('dtaksespoli', 'dtuser', 'dtpoli', 'roleuser', 'menu'));
    }

    public function update(Request $request, $id)
    {
        DataAksesPoli::where('id_akses_poli', $id)->update([
            'id_poli' => $request->poli,
            'id_user' => $request->user
        ]);
        return redirect()->route('akses-poli');
    }

    public function destroy($id)
    {

        $dtaksespoli = DataAksesPoli::where('id_akses_poli', $id);
        $dtaksespoli->delete();
        return redirect()->route('akses-poli');
    }
}
