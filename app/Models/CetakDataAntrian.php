<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CetakDataAntrian extends Model
{
    use HasFactory;
    protected $table = 'cetak_data_antrian';
    protected $fillable = [
        'id_antrian',
        'id_poli',
        'nomor_antrian',
        'tanggal_antrian',
    ];

    public function poli()
    {
        return $this->belongsTo(DataPoli::class, 'id_poli', 'id_poli');
    }
}
