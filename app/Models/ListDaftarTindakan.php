<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListDaftarTindakan extends Model
{
    use HasFactory;
    public $table = 'list_daftar_tindakan_pasien';
    protected $fillable = [
        'list_id',
        'kode_pendaftaran',
        'nama_tindakan',
        'harga_tindakan'
    ];

    public function daftar()
    {
        return $this->belongsTo(PendaftaranPasien::class, 'kode_pendaftaran', 'kode_pendaftaran');
    }

    public function tindakan()
    {
        return $this->belongsTo(DataTindakan::class, 'nama_tindakan', 'nama_tindakan');
    }
}
