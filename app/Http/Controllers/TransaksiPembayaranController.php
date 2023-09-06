<?php

namespace App\Http\Controllers;

use App\Models\RumahSakit;
use Illuminate\Http\Request;
use App\Http\Traits\Terbilang;
use App\Models\ListDaftarObat;
use App\Models\PendaftaranPasien;
use App\Models\ListDaftarTindakan;
use Illuminate\Support\Facades\Auth;

class TransaksiPembayaranController extends Controller
{
    use Terbilang;
    public function index()
    {
        $dtpendaftar = PendaftaranPasien::where('status_pemeriksaan', 'Tertangani')
            ->where('status_obat', 'Tertangani')
            ->with('pasien')
            ->orderBy('kode_pendaftaran', 'desc')
            ->paginate(10);

        return view('transaksipembayaran.transaksipembayaran', compact('dtpendaftar'));
    }

    public function detail($id)
    {
        $dtpendaftar = PendaftaranPasien::where('kode_pendaftaran', $id)->with('pasien')->get();
        $dtlistobat =  ListDaftarObat::where('kode_pendaftaran', $id)->with('obat')->get();
        $dtlisttindakan =  ListDaftarTindakan::where('kode_pendaftaran', $id)->with('tindakan')->get();

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

        foreach ($dtpendaftar as $pendaftaran) {
            $pasien_id = $pendaftaran->pasien_id;
            $dtriwayat = PendaftaranPasien::where('pasien_id', $pasien_id)->where('status_pemeriksaan', 'Tertangani')->with('poli', 'user', 'listobat', 'listtindakan')->get();
        }
        return view('transaksipembayaran.detailpembayaran', compact('dtpendaftar', 'dtriwayat', 'dtlistobat', 'dtlisttindakan', 'total', 'grandtotal'));
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
        return redirect()->route('transaksi-pembayaran');
    }

    public function print($id)
    {
        $namaKasir = Auth::user()->User_name;
        $rs = RumahSakit::first();
        $dtpendaftar = PendaftaranPasien::where('kode_pendaftaran', $id)->with('pasien')->get();
        $dtlistobat =  ListDaftarObat::where('kode_pendaftaran', $id)->with('obat')->get();
        $dtlisttindakan =  ListDaftarTindakan::where('kode_pendaftaran', $id)->with('tindakan')->get();

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

        $terbilang = ucwords($this->pembilang($grandtotal).' rupiah');

        foreach ($dtpendaftar as $pendaftaran) {
            $pasien_id = $pendaftaran->pasien_id;
            $dtriwayat = PendaftaranPasien::where('pasien_id', $pasien_id)->where('status_pemeriksaan', 'Tertangani')->with('poli', 'user', 'listobat', 'listtindakan')->get();
        }
        return view('transaksipembayaran.printdetailpembayaran', compact('dtpendaftar', 'dtriwayat', 'dtlistobat', 'dtlisttindakan', 'total', 'grandtotal', 'rs', 'namaKasir', 'terbilang'));
    }

    public function terbilang()
    {
        $angka = 10250500;
        $jumlahNilai = ucwords($this->pembilang($angka).' rupiah');
        echo  ('Terbilang = '. $jumlahNilai);
    }
}
