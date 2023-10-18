<?php

namespace App\Http\Controllers;

use App\Models\RumahSakit;
use Illuminate\Http\Request;

class CekRiwayatPasienController extends Controller
{
    public function index()
    {
        $rs = RumahSakit::first();
        return view('cekriwayatpasien.formpencarian', compact('rs'));
    }
}
