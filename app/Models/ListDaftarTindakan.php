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
        'kode_pasien',
        'nama_tindakan',
        'harga_tindakan'
    ];

    public function pasien()
    {
        return $this->belongsTo(DataPasien::class, 'kode_pasien', 'pasien_kode');
    }
}
