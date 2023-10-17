<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\RumahSakit;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Http\Traits\Terbilang;
use App\Models\ListDaftarObat;
use App\Models\ListDaftarRujukan;
use App\Models\PendaftaranPasien;
use App\Models\ListDaftarTindakan;
use Illuminate\Support\Facades\Auth;

class TransaksiPembayaranRawatJalanController extends Controller
{
    use Terbilang;
    public function index()
    {
        $dtpendaftar = PendaftaranPasien::where('status_pemeriksaan', 'Tertangani')
            ->where('status_obat', 'Tertangani')
            ->with('pasien')
            ->orderBy('kode_pendaftaran', 'desc')
            ->paginate(10);
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('transaksipembayaranrawatjalan.transaksipembayaran', compact('dtpendaftar', 'menu', 'roleuser'));
    }

    public function search(Request $request)
    {
        $searchTerm = $request->get('cari');
        $data = PendaftaranPasien::where('status_pemeriksaan', 'Tertangani')->where('status_obat', 'Tertangani')->with('pasien')
            ->where(function ($query) use ($searchTerm) {
                $query->whereHas('pasien', function ($subquery) use ($searchTerm) {
                    $subquery->where('pasien_nama', 'LIKE', '%' . $searchTerm . '%');
                });
            })
            ->get();
        return response()->json($data);
    }

    public function detail($id)
    {
        $dtpendaftar = PendaftaranPasien::where('kode_pendaftaran', $id)->with('pasien')->get();
        $dtlistobat =  ListDaftarObat::where('kode_pendaftaran', $id)->with('obat')->get();
        $dtlisttindakan =  ListDaftarTindakan::where('kode_pendaftaran', $id)->with('tindakan')->get();
        $dtlistrujukan = ListDaftarRujukan::where('kode_pendaftaran', $id)->with('tindakanlab', 'lab')->get();

        $total = 0;
        foreach ($dtlistobat as $obat) {
            if ($obat->obat->status == 'Ada') {
                $total += $obat->obat->harga_jual * $obat->qty;
            } else {
                $total += $obat->obat->harga_jual * 0;
            }
        }

        $grandtotal = $total;
        foreach ($dtlisttindakan as $tindakan) {
            $grandtotal += $tindakan->tindakan->harga_tindakan;
        }

        foreach ($dtlistrujukan as $rujukan) {
            $grandtotal += $rujukan->tindakanlab->harga_tindakan;
        }


        foreach ($dtpendaftar as $pendaftaran) {
            $pasien_id = $pendaftaran->pasien_id;
            $dtriwayat = PendaftaranPasien::where('pasien_id', $pasien_id)->where('status_pemeriksaan', 'Tertangani')->with('poli', 'user', 'listobat', 'listtindakan')->get();
        }
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('transaksipembayaranrawatjalan.detailpembayaran', compact('dtpendaftar', 'dtriwayat', 'dtlistobat', 'dtlisttindakan', 'total', 'grandtotal', 'roleuser', 'menu', 'dtlistrujukan'));
    }

    public function transaksi(Request $request, $id)
    {
        $grandtotal = floatval($request->input('grandtotal'));
        $dibayar = floatval($request->input('dibayar'));

        $kembalian = $dibayar - $grandtotal;

        $updatedata = [
            'grandtotal' => $grandtotal,
            'dibayar' => $dibayar,
            'kembalian' => $kembalian
        ];
        PendaftaranPasien::where('kode_pendaftaran', $id)->update($updatedata);
        return redirect()->route('transaksi-pembayaran-rawatjalan');
    }

    public function print($id)
    {
        $namaKasir = Auth::user()->User_name;
        $rs = RumahSakit::first();
        $dtpendaftar = PendaftaranPasien::where('kode_pendaftaran', $id)->with('pasien')->get();
        $dtlistobat =  ListDaftarObat::where('kode_pendaftaran', $id)->with('obat')->get();
        $dtlisttindakan =  ListDaftarTindakan::where('kode_pendaftaran', $id)->with('tindakan')->get();
        $dtlistrujukan = ListDaftarRujukan::where('kode_pendaftaran', $id)->with('tindakanlab', 'lab')->get();

        $total = 0;
        foreach ($dtlistobat as $obat) {
            if ($obat->obat->status == 'Ada') {
                $total += $obat->obat->harga_jual * $obat->qty;
            } else {
                $total += $obat->obat->harga_jual * 0;
            }
        }

        $grandtotal = $total;
        foreach ($dtlisttindakan as $tindakan) {
            $grandtotal += $tindakan->tindakan->harga_tindakan;
        }

        foreach ($dtlistrujukan as $rujukan) {
            $grandtotal += $rujukan->tindakanlab->harga_tindakan;
        }

        $terbilang = ucwords($this->pembilang($grandtotal) . ' rupiah');

        foreach ($dtpendaftar as $pendaftaran) {
            $pasien_id = $pendaftaran->pasien_id;
            $dtriwayat = PendaftaranPasien::where('pasien_id', $pasien_id)->where('status_pemeriksaan', 'Tertangani')->with('poli', 'user', 'listobat', 'listtindakan')->get();
        }
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('transaksipembayaranrawatjalan.printdetailpembayaran', compact(
            'dtpendaftar',
            'dtriwayat',
            'dtlistobat',
            'dtlisttindakan',
            'total',
            'grandtotal',
            'rs',
            'namaKasir',
            'terbilang',
            'roleuser',
            'dtlistrujukan'
        ));
    }

    public function terbilang()
    {
        $angka = 10250500;
        $jumlahNilai = ucwords($this->pembilang($angka) . ' rupiah');
        echo ('Terbilang = ' . $jumlahNilai);
    }
}
