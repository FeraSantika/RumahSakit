<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RumahSakit extends Model
{
    use HasFactory;
    protected $table = 'data_rumah_sakit';
    protected $fillable = [
        'id_rumahsakit',
        'nama_rumahsakit',
        'alamat_rumahsakit',
        'logo_rumahsakit',
        'telp_rumahsakit',
        'email_rumahsakit',
    ];
}
