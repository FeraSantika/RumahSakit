<?php

namespace App\Http\Controllers;

use App\Models\DataPoli;
use App\Models\DataUser;
use Illuminate\Http\Request;
use App\Models\DataAksesPoli;

class AksespoliController extends Controller
{
        public function index()
        {
            $dtaksespoli = DataAksesPoli::get();
            return view('aksespoli.aksespoli', compact('dtaksespoli'));
        }

        public function create()
        {
            $dtuser = DataUser::get();
            $dtpoli = DataPoli::get();
            return view('aksespoli.create', compact('dtuser', 'dtpoli'));
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
            return view('aksespoli.edit', compact('dtaksespoli', 'dtuser', 'dtpoli'));
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
