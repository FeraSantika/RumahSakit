<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPoli extends Model
{
    use HasFactory;
    protected $table = 'data_poli';
    protected $fillable = [
        'id_poli',
        'kode_poli',
        'nama_poli',
    ];

    public function antrian(){
        return $this->belongsTo(DataAntrian::class, 'id_poli', 'id_poli');
    }
}
