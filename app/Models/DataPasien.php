<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPasien extends Model
{
    use HasFactory;
    protected $table = 'data_pasien';
    protected $fillable = [
        'pasien_id',
        'pasien_kode',
        'pasien_NIK',
        'pasien_nama',
        'pasien_tempat_lahir',
        'pasien_tgl_lahir',
        'pasien_jenis_kelamin',
        'pasien_alamat',
        'pasien_agama',
        'pasien_status',
        'pasien_pekerjaan',
        'pasien_kewarganegaraan',
    ];

    public function daftarobat()
    {
        return $this->belongsTo(ListDaftarObat::class, 'pasien_kode','kode_pasien');
    }

    public function daftar()
    {
        return $this->hasMany(PendaftaranPasien::class,'id_pasien', 'pasien_id');
    }
}
