<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\RumahSakit;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;

class RumahsakitController extends Controller
{
    public function index()
    {
        $rumahsakit = RumahSakit::get();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('rumahsakit.rumahsakit', compact('rumahsakit', 'menu', 'roleuser'));
    }

    public function create()
    {
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();

        return view('rumahsakit.create', compact('roleuser', 'menu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $destinationPath = 'images/';
            $filename = date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $path = $destinationPath . $filename;
        } else {
            $path = null;
        }

        RumahSakit::create([
            'nama_rumahsakit' => $request->nama,
            'alamat_rumahsakit' => $request->alamat,
            'telp_rumahsakit' => $request->telp,
            'email_rumahsakit' => $request->email,
            'logo_rumahsakit' => $path
        ]);

        return redirect()->route('rumah_sakit');
    }

    public function edit($id)
    {
        $rumahsakit = RumahSakit::where('id_rumahsakit', $id)->first();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();

        return view('rumahsakit.edit', compact('rumahsakit', 'roleuser', 'menu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $rsData = [
            'nama_rumahsakit' => $request->nama,
            'alamat_rumahsakit' => $request->alamat,
            'telp_rumahsakit' => $request->telp,
            'email_rumahsakit' => $request->email,
        ];

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $destinationPath = 'images/';
            $filename = date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $path = $destinationPath . $filename;
            $rsData['logo_rumahsakit'] = $path;
        }

        RumahSakit::where('id_rumahsakit', $id)->update($rsData);

        return redirect()->route('rumah_sakit');
    }

    public function destroy($id)
    {
        $rs = RumahSakit::where('id_rumahsakit', $id);
        $rs->delete();
        return redirect()->route('rumah_sakit');
    }
}
