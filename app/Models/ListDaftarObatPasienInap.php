<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListDaftarObatPasienInap extends Model
{
    use HasFactory;
    public $table = 'list_daftar_obat_pasienInap';
    protected $fillable = [
        'list_id',
        'kode_pendaftaran',
        'nama_obat',
        'kategori_obat',
        'qty',
        'status',
        'tanggal'
    ];

    public function daftar()
    {
        return $this->belongsTo(PendaftaranPasienInap::class, 'kode_pendaftaran', 'kode_pendaftaran');
    }

    public function obat()
    {
        return $this->belongsTo(DataObat::class, 'nama_obat', 'nama_obat');
    }
}
