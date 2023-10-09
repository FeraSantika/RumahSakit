<?php

namespace App\Http\Controllers;

use App\Models\DataLab;
use App\Models\DataMenu;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\DataTindakanLab;

class TindakanLabController extends Controller
{
    public function index()
    {
        $dttindakan = DataTindakanLab::paginate(10);
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('tindakanlab.tindakanlab', compact('dttindakan', 'menu', 'roleuser'));
    }

    public function create()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $dtlab = DataLab::get();
        return view('tindakanlab.create', compact('roleuser', 'menu', 'dtlab'));
    }

    public function store(Request $request)
    {
        DataTindakanLab::create([
            'id_lab' => $request->lab,
            'nama_tindakan' => $request->nama,
            'harga_tindakan' => $request->harga
        ]);

        return redirect()->route('tindakan-lab');
    }

    public function edit($id)
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $dttindakan = DataTindakanLab::where('id_tindakan', $id)->with('lab')->first();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $dtlab = DataLab::get();
        return view('tindakanlab.edit', compact('dttindakan', 'roleuser', 'menu', 'dtlab'));
    }

    public function update(Request $request, $id_tindakan)
    {
        DataTindakanLab::where('id_tindakan', $id_tindakan)->update([
            'id_lab' => $request->lab,
            'nama_tindakan' => $request->nama,
            'harga_tindakan' => $request->harga,
        ]);

        return redirect()->route('tindakan-lab');
    }

    public function destroy($id_tindakan)
    {
        DataTindakanLab::where('id_tindakan', $id_tindakan)->delete();

        return redirect()->route('tindakan-lab');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->get('cari');

        $data = DataTindakanLab::where(function ($query) use ($searchTerm) {
            $query->where('nama_tindakan', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('harga_tindakan', 'LIKE', '%' . $searchTerm . '%')
                ->orWhereHas('lab', function ($query) use ($searchTerm) {
                    $query->where('nama_lab', 'LIKE', '%' . $searchTerm . '%');
                });
        })
            ->with('lab')
            ->get();
        return response()->json($data);
    }
}
