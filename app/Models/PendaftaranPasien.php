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
        'status_pasien'
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
}
