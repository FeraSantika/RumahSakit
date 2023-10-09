<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\DataUser;
use App\Models\DataRoleMenu;
use App\Models\JadwalDokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalDokterController extends Controller
{
    public function index()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $dtjadwal = JadwalDokter::with('user')->paginate(10);
        return view('jadwaldokter.jadwaldokter', compact('menu', 'roleuser', 'dtjadwal'));
    }

    public function create()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $dokter = DataUser::where('Role_id', 1)->get();
        return view('jadwaldokter.create', compact('menu', 'roleuser', 'dokter'));
    }

    public function store(Request $request)
    {
        JadwalDokter::create([
            'User_id' => $request->user_id,
            'nama_hari' => $request->hari,
            'jam_mulai' => $request->mulai,
            'jam_selesai' => $request->selesai,
        ]);

        return redirect()->route('jadwal-dokter');
    }

    public function edit($id)
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $dokter = DataUser::where('Role_id', 1)->get();
        $jadwal = JadwalDokter::where('id_jadwal', $id)->first();
        return view('jadwaldokter.edit', compact('roleuser', 'menu', 'jadwal', 'dokter'));
    }

    public function update(Request $request, $id)
    {
        JadwalDokter::where('id_jadwal', $id)->update([
            'User_id' => $request->user_id,
            'nama_hari' => $request->hari,
            'jam_mulai' => $request->mulai,
            'jam_selesai' => $request->selesai,
        ]);

        return redirect()->route('jadwal-dokter');
    }

    public function destroy($id)
    {
        JadwalDokter::where('id_jadwal', $id)->delete();

        return redirect()->route('jadwal-dokter');
    }

    public function autocomplete(Request $request)
    {
        $searchTerm = $request->input('cari');

        $data = JadwalDokter::with('user')
            ->whereHas('user', function ($query) use ($searchTerm) {
                $query->where('User_name', 'like', '%' . $searchTerm . '%');
            })
            ->get()
            ->map(function ($item) {
                return [
                    'value' => $item->user->User_name,
                    'id' => $item->user->User_id,
                ];
            });

        return response()->json($data);
    }
}
