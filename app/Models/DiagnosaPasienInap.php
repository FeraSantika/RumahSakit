<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiagnosaPasienInap extends Model
{
    use HasFactory;
    protected $table = 'diagnosa_pasien_inap';
    protected $primaryKey = 'id_diagnosa_pasieninap';
    protected $fillable = [
        'id_diagnosa_pasieninap',
        'kode_pendaftaran',
        'diagnosa',
        'tanggal'
    ];
}
