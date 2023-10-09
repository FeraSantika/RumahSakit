<?php

namespace App\Models;

use App\Models\DataPoli;
use App\Models\DataUser;
use App\Models\DataPasien;
use App\Models\DataAksesPoli;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PendaftaranPasien extends Model
{
    use HasFactory;
    protected $table = 'pendaftaran_pasien';
    protected $fillable = [
        'id_pendaftaran',
        'kode_pendaftaran',
        'pasien_id',
        'id_poli',
        'keluhan',
        'status_pasien',
        'diagnosa',
        'petugas',
        'status_pemeriksaan',
        'status_obat',
        'grandtotal',
        'dibayar',
        'kembalian',
    ];

    public function pasien()
    {
        return $this->belongsTo(DataPasien::class, 'pasien_id', 'pasien_id');
    }

    public function poli()
    {
        return $this->belongsTo(DataPoli::class, 'id_poli', 'id_poli');
    }

    public function aksespoli()
    {
        return $this->belongsTo(DataAksesPoli::class, 'id_poli', 'id_poli');
    }

    public function user()
    {
        return $this->belongsTo(DataUser::class, 'petugas', 'User_id');
    }

    public function obat()
    {
        return $this->belongsTo(DataObat::class, 'petugas', 'User_id');
    }

    public function listobat()
    {
        return $this->belongsTo(ListDaftarObat::class, 'kode_pendaftaran', 'kode_pendaftaran');
    }

    public function listtindakan()
    {
        return $this->belongsTo(ListDaftarTindakan::class, 'kode_pendaftaran', 'kode_pendaftaran');
    }

    public function listrujukan()
    {
        return $this->belongsTo(ListDaftarRujukan::class, 'kode_pendaftaran', 'kode_pendaftaran');
    }
}
