<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\DataMenu;
use App\Models\RumahSakit;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Http\Traits\Terbilang;
use App\Models\KamarPasienInap;
use App\Models\DiagnosaPasienInap;
use Illuminate\Support\Facades\Auth;
use App\Models\PendaftaranPasienInap;
use App\Models\ListDaftarObatPasienInap;
use App\Models\ListDaftarRujukanPasienInap;
use App\Models\ListDaftarTindakanPasienInap;

class TransaksiPembayaranRawatInapController extends Controller
{
    use Terbilang;
    public function index()
    {
        $dtpendaftar = PendaftaranPasienInap::where('status_pemeriksaan', 'Tertangani')
            ->with('pasien')
            ->orderBy('kode_pendaftaran', 'desc')
            ->paginate(10);
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('transaksipembayaranrawatinap.transaksipembayaran', compact('dtpendaftar', 'menu', 'roleuser'));
    }

    public function detail($id)
    {
        $dtpendaftar = PendaftaranPasienInap::where('kode_pendaftaran', $id)->with('pasien')->get();
        $dtlistobat =  ListDaftarObatPasienInap::where('kode_pendaftaran', $id)->with('obat')->get();
        $dtlisttindakan =  ListDaftarTindakanPasienInap::where('kode_pendaftaran', $id)->with('tindakan')->get();
        $dtlistkamar =  KamarPasienInap::where('kode_pendaftaran', $id)->with('kamar')->get();
        $dtdiagnosa = DiagnosaPasienInap::where('kode_pendaftaran', $id)->get();
        $dtlistrujukan = ListDaftarRujukanPasienInap::where('kode_pendaftaran', $id)->with('tindakanlab', 'lab')->get();

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

        $harga = 0;
        $waktu = 0;
        foreach ($dtlistkamar as $kamar) {
            $tanggalMasuk = new DateTime($kamar->tanggal_masuk);
            $tanggalKeluar = new DateTime($kamar->tanggal_keluar);
            $waktu = $tanggalMasuk->diff($tanggalKeluar)->days;

            $kamarinap = $kamar->kamar->harga_kamar_inap;
            $harga = $kamarinap * $waktu;
        }

        foreach ($dtpendaftar as $pendaftaran) {
            $pasien_id = $pendaftaran->pasien_id;
            $dtriwayat = PendaftaranPasienInap::where('pasien_id', $pasien_id)->where('status_pemeriksaan', 'Tertangani')->with('user', 'listobat', 'listtindakan')->get();
        }
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('transaksipembayaranrawatinap.detailpembayaran', compact('dtpendaftar', 'dtriwayat', 'dtlistobat', 'dtlisttindakan', 'total', 'grandtotal', 'dtlistkamar', 'harga', 'waktu', 'dtdiagnosa', 'roleuser', 'menu', 'dtlistrujukan'));
    }

    public function search(Request $request)
    {
        $searchTerm = $request->get('cari');

        $data = PendaftaranPasienInap::where('status_pemeriksaan', 'Tertangani')->with('pasien')
            ->where(function ($query) use ($searchTerm) {
                $query->whereHas('pasien', function ($subquery) use ($searchTerm) {
                    $subquery->where('pasien_nama', 'LIKE', '%' . $searchTerm . '%');
                });
            })
            ->get();

        return response()->json($data);
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
        PendaftaranPasienInap::where('kode_pendaftaran', $id)->update($updatedata);
        return redirect()->route('transaksi-pembayaran-rawatinap');
    }

    public function print($id)
    {
        $namaKasir = Auth::user()->User_name;
        $rs = RumahSakit::first();
        $dtpendaftar = PendaftaranPasienInap::where('kode_pendaftaran', $id)->with('pasien')->get();
        $dtlistobat =  ListDaftarObatPasienInap::where('kode_pendaftaran', $id)->with('obat')->get();
        $dtlisttindakan =  ListDaftarTindakanPasienInap::where('kode_pendaftaran', $id)->with('tindakan')->get();
        $dtlistkamar =  KamarPasienInap::where('kode_pendaftaran', $id)->with('kamar')->get();
        $dtdiagnosa = DiagnosaPasienInap::where('kode_pendaftaran', $id)->get();
        $dtpendaftarinap = PendaftaranPasienInap::where('kode_pendaftaran', $id)->first();
        $dtlistrujukan = ListDaftarRujukanPasienInap::where('kode_pendaftaran', $id)->with('tindakanlab', 'lab')->get();

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

        $grandtotalinap = $dtpendaftarinap->grandtotal;
        $terbilanggrandtotal = ucwords($this->pembilang($grandtotalinap) . ' rupiah');

        foreach ($dtpendaftar as $pendaftaran) {
            $pasien_id = $pendaftaran->pasien_id;
            $dtriwayat = PendaftaranPasienInap::where('pasien_id', $pasien_id)->where('status_pemeriksaan', 'Tertangani')->with('user', 'listobat', 'listtindakan')->get();
        }
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('transaksipembayaranrawatinap.printdetailpembayaran', compact('dtpendaftar', 'dtriwayat', 'dtlistobat', 'dtlisttindakan', 'total', 'grandtotal', 'rs', 'namaKasir', 'terbilanggrandtotal', 'dtlistkamar', 'dtdiagnosa', 'roleuser', 'dtlistrujukan'));
    }

    public function terbilang(Request $request)
    {
        $grandtotal = $request->input('grandtotal');
        $jumlahNilai = ucwords($this->pembilang($grandtotal) . ' rupiah');

        return view('nama.blade.template', compact('grandtotal', 'jumlahNilai'));
    }
}
