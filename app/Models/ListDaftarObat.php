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
        'kode_pasien',
        'nama_obat',
        'kategori_obat',
        'qty'
    ];

    public function pasien()
    {
        return $this->belongsTo(DataPasien::class, 'kode_pasien', 'pasien_kode');
    }
}
