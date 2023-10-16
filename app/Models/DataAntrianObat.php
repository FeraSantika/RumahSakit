<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAntrianObat extends Model
{
    use HasFactory;
    protected $table = 'data_antrian_obat';
    protected $fillable = [
        'id_antrian',
        'nomor_antrian',
        'tanggal_antrian',
        'status_antrian'
    ];
}
