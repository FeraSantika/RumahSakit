<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\DataUser;
use App\Models\DataAksesLab;
use App\Models\DataLab;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;

class AksesLabController extends Controller
{
    public function index()
    {
        $dtakseslab = DataAksesLab::paginate(10);
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('akseslab.akseslab', compact('dtakseslab', 'menu', 'roleuser'));
    }

    public function create()
    {
        $dtuser = DataUser::get();
        $dtlab = DataLab::get();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('akseslab.create', compact('dtuser', 'dtlab', 'menu', 'roleuser'));
    }

    public function store(Request $request)
    {
        DataAksesLab::create([
            'id_lab' => $request->lab,
            'id_user' => $request->user
        ]);

        return redirect()->route('akses-lab');
    }

    public function edit($id)
    {
        $dtuser = DataUser::get();
        $dtlab = DataLab::get();
        $dtakseslab = DataAksesLab::where('id_akses_lab', $id)->first();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('akseslab.edit', compact('dtakseslab', 'dtuser', 'dtlab', 'roleuser', 'menu'));
    }

    public function update(Request $request, $id)
    {
        DataAksesLab::where('id_akses_lab', $id)->update([
            'id_lab' => $request->lab,
            'id_user' => $request->user
        ]);
        return redirect()->route('akses-lab');
    }

    public function destroy($id)
    {

        $dtakseslab = DataAksesLab::where('id_akses_lab', $id);
        $dtakseslab->delete();
        return redirect()->route('akses-lab');
    }
}
