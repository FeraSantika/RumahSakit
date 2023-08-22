<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataAksesPoli;
use App\Models\PendaftaranPasien;
use Illuminate\Support\Facades\Auth;
use PharIo\Manifest\Author;

class ListdaftarpasienController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $akses = $user->poliakses;
        $dtpendaftar = PendaftaranPasien::with(['aksespoli.user'])
            ->whereHas('aksespoli.user', function ($query) use ($user) {
                $query->where('User_id', $user->User_id);
            })
            ->get();
        return view('listdaftarpasien.listdaftarpasien', compact('dtpendaftar'));
    }
}
