<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranPasien extends Model
{
    use HasFactory;
    protected $table = 'pendaftaran_pasien';
    protected $fillable = [
        'id_pendaftaran',
        'kode_pendaftaran',
        'pasien_id',
        'id_poli',
    ];

    public function pasien(){
        return $this->hasMany(DataPasien::class, 'pasien_id', 'pasien_id');
    }

    public function poli(){
        return $this->hasMany(DataPoli::class, 'id_poli', 'id_poli');
    }
}
