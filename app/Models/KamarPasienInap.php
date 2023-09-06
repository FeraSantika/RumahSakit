<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KamarPasienInap extends Model
{
    use HasFactory;
    protected $table = 'kamar_pasien_inap';
    protected $fillable = [
        'id_kamar_pasieninap',
        'tanggal_masuk',
        'tanggal_keluar',
        'id_kamar_inap',
        'kode_pendaftaran',
    ];

    public function kamar()
    {
        return $this->belongsTo(DataKamarInap::class, 'id_kamar_inap', 'id_kamar_inap');
    }
}
