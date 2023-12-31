<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListDaftarObat extends Model
{
    use HasFactory;
    public $table = 'list_daftar_obat_pasien';
    protected $fillable = [
        'list_id',
        'kode_pendaftaran',
        'nama_obat',
        'kategori_obat',
        'qty',
        'status'
    ];

    public function daftar()
    {
        return $this->belongsTo(PendaftaranPasien::class, 'kode_pendaftaran', 'kode_pendaftaran');
    }

    public function obat()
    {
        return $this->belongsTo(DataObat::class, 'nama_obat', 'nama_obat');
    }

}
