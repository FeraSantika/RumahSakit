<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\DataRoleMenu;
use App\Models\DataTindakan;
use Illuminate\Http\Request;

class TindakanController extends Controller
{
    public function index()
    {
        $dttindakan = DataTindakan::paginate(10);
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('tindakan.tindakan', compact('dttindakan', 'menu', 'roleuser'));
    }

    public function create()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('tindakan.create',compact('roleuser', 'menu'));
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
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $dttindakan = DataTindakan::where('id_tindakan', $id)->first();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('tindakan.edit', compact('dttindakan', 'roleuser', 'menu'));
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
