<?php

namespace App\Http\Controllers;

use App\Models\DataLab;
use App\Models\DataMenu;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;

class LabController extends Controller
{
    public function index()
    {
        $dtlab = DataLab::paginate(10);
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $lab = DataLab::get();
        return view('lab.lab', compact('menu', 'roleuser', 'dtlab'));
    }

    public function create()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('lab.create', compact('menu', 'roleuser'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        DataLab::create([
            'nama_lab' => $request->nama,
        ]);

        return redirect()->route('lab');
    }

    public function edit($id)
    {
        $dtlab = Datalab::where('id_lab', $id)->first();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('lab.edit', compact('dtlab', 'menu', 'roleuser'));
    }

    public function update(Request $request, $id)
    {
        $lab = [
            'nama_lab' => $request->nama,
        ];

        Datalab::where('id_lab', $id)->update($lab);
        return redirect()->route('lab');
    }

    public function destroy($id)
    {
        $lab = Datalab::where('id_lab', $id);
        $lab->delete();
        return redirect()->route('lab');
    }
}
