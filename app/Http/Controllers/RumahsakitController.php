<?php

namespace App\Http\Controllers;

use App\Models\RumahSakit;
use Illuminate\Http\Request;

class RumahsakitController extends Controller
{
    public function index()
    {
        $rumahsakit = RumahSakit::get();
        return view('rumahsakit.rumahsakit', compact('rumahsakit'));
    }

    public function create()
    {
        return view('rumahsakit.create');
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
        return view('rumahsakit.edit', compact('rumahsakit'));
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
