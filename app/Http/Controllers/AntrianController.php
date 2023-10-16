<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\DataPoli;
use App\Models\RumahSakit;
use App\Models\DataAntrian;
use App\Models\DataAntrianObat;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;

class AntrianController extends Controller
{
    public function index()
    {
        $rs = RumahSakit::first();
        $today = now()->format('Y-m-d');
        $antrian = DataAntrian::orderBy('updated_at', 'desc')->whereDate('tanggal_antrian', $today)->with('poli')->first();
        $antrianobat = DataAntrianObat::orderBy('updated_at', 'desc')->whereDate('tanggal_antrian', $today)->first();
        // dd($antrian);
        return view('antrian', compact('rs', 'antrian', 'antrianobat'));
    }

    public function antrian()
    {
        $today = now()->format('Y-m-d');
        $poli = DataPoli::with(['antrian' => function ($query) use ($today) {
            $query->whereDate('tanggal_antrian', $today);
        }])->get();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        return view('antrian.antrian', compact('poli', 'menu', 'roleuser'));
    }

    public function hitungantrian(Request $request)
    {
        $id_poli = $request->input('id_poli');
        $today = now()->format('Y-m-d');
        $poli = DataAntrian::where('id_poli', $id_poli)->whereDate('tanggal_antrian', $today)->first();
        if ($poli) {
            $poli->where('id_poli', $id_poli)->update([
                'nomor_antrian' => $poli->nomor_antrian + 1,
                'tanggal_antrian' => now(),
                'status_antrian' => '0'
            ]);
            return redirect()->back()->with('success', 'Nomor antrian berhasil diperbarui.');
        } else {
            DataAntrian::create([
                'nomor_antrian' => 1,
                'id_poli' => $id_poli,
                'tanggal_antrian' => now(),
                'status_antrian' => '0'
            ]);
            return redirect()->back()->with('success', 'Nomor antrian berhasil ditambahkan.');
        }
    }

    public function ubahstatus(Request $request)
    {
        $id_poli = $request->input('id_poli');
        $today = now()->format('Y-m-d');
        $poli = DataAntrian::where('id_poli', $id_poli)->whereDate('tanggal_antrian', $today)->first();

        if ($poli) {
            $poli->where('id_poli', $id_poli)->update([
                'status_antrian' => '1'
            ]);
            return redirect()->back()->with('success', 'Status antrian berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Data antrian tidak ditemukan.');
        }
    }

    public function getNomorAntrian(Request $request)
    {
        $today = now()->format('Y-m-d');
        $nomor_antrian = DataAntrian::whereDate('tanggal_antrian', $today)->latest('updated_at')->value('nomor_antrian');
        $dataAntrian = DataAntrian::whereDate('tanggal_antrian', $today)->latest('updated_at')->with('poli')->first();
        $nama_poli = $dataAntrian->poli->nama_poli;
        $kode_poli = $dataAntrian->poli->kode_poli;

        $update = DataAntrian::where('id_antrian', $dataAntrian->id_antrian)->update([
            'status_antrian' => '0'
        ]);
        return response()->json([
            'nomor_antrian' => $nomor_antrian,
            'nama_poli' => $nama_poli,
            'status' => $dataAntrian->status_antrian,
            'kode' => $kode_poli,
        ]);
    }

    public function hitungantrianobat(Request $request)
    {
        $id_antrian = $request->input('id_antrian');
        $today = now()->format('Y-m-d');
        $antrian = DataAntrianObat::whereDate('tanggal_antrian', $today)->first();
        if ($antrian) {
            $antrian->where('id_antrian', $id_antrian)->update([
                'nomor_antrian' => $antrian->nomor_antrian + 1,
                'tanggal_antrian' => now(),
                'status_antrian' => '0'
            ]);
            return redirect()->back()->with('success', 'Nomor antrian berhasil diperbarui.');
        } else {
            DataAntrianObat::create([
                'nomor_antrian' => 1,
                'tanggal_antrian' => now(),
                'status_antrian' => '0'
            ]);
            return redirect()->back()->with('success', 'Nomor antrian berhasil ditambahkan.');
        }
    }

    public function ubahstatusobat(Request $request)
    {
        $id_antrian = $request->input('id_antrian');
        $today = now()->format('Y-m-d');
        $antrian = DataAntrianObat::whereDate('tanggal_antrian', $today)->first();

        if ($antrian) {
            $antrian->where('id_antrian', $id_antrian)->update([
                'status_antrian' => '1'
            ]);
            return redirect()->back()->with('success', 'Status antrian berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Data antrian tidak ditemukan.');
        }
    }

    public function getNomorAntrianobat()
    {
        $today = now()->format('Y-m-d');
        $nomor_antrian = DataAntrianObat::whereDate('tanggal_antrian', $today)->value('nomor_antrian');
        $dataAntrian = DataAntrianObat::whereDate('tanggal_antrian', $today)->first();

        $update = DataAntrianObat::where('id_antrian', $dataAntrian->id_antrian)->update([
            'status_antrian' => '0'
        ]);
        return response()->json([
            'nomor_antrian' => $nomor_antrian,
            'status' => $dataAntrian->status_antrian,
        ]);
    }
}
