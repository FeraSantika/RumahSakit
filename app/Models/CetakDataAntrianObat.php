<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CetakDataAntrianObat extends Model
{
    use HasFactory;
    protected $table = 'cetak_data_antrian_obat';
    protected $fillable = [
        'id_antrian',
        'nomor_antrian',
        'tanggal_antrian',
    ];
}
