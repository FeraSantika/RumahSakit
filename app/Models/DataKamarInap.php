<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKamarInap extends Model
{
    use HasFactory;
    protected $table = 'data_kamar_inap';
    protected $fillable = [
        'id_kamar_inap',
        'nama_kamar_inap',
        'nomor_kamar_inap',
        'harga_kamar_inap'
    ];

    public function kamarPasienInap()
    {
        return $this->hasMany(KamarPasienInap::class, 'id_kamar_inap', 'id_kamar_inap');
    }
}
