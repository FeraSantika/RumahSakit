<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranPasienInap extends Model
{
    use HasFactory;
    protected $table = 'pendaftaran_pasien_inap';
    protected $fillable = [
        'id_pendaftaran',
        'kode_pendaftaran',
        'pasien_id',
        'keluhan',
        'status_pasien',
        'status_pemeriksaan',
        'petugas',
        'grandtotal',
        'dibayar',
        'kembalian'
    ];

    public function pasien()
    {
        return $this->belongsTo(DataPasien::class, 'pasien_id', 'pasien_id');
    }

    public function user()
    {
        return $this->belongsTo(DataUser::class, 'petugas', 'User_id');
    }

    public function listobat()
    {
        return $this->belongsTo(ListDaftarObatPasienInap::class, 'kode_pendaftaran', 'kode_pendaftaran');
    }

    public function listtindakan()
    {
        return $this->belongsTo(ListDaftarTindakanPasienInap::class, 'kode_pendaftaran', 'kode_pendaftaran');
    }

    public function listrujukan()
    {
        return $this->belongsTo(ListDaftarRujukanPasienInap::class, 'kode_pendaftaran', 'kode_pendaftaran');
    }
}
