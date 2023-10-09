<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalDokter extends Model
{
    use HasFactory;
    protected $table = 'jadwal_dokter';
    protected $fillable = [
        'id_jadwal',
        'User_id',
        'nama_hari',
        'jam_mulai',
        'jam_selesai',
    ];

    public function user()
    {
        return $this->belongsTo(DataUser::class, 'User_id', 'User_id');
    }

    public function hari(){
        return $this->belongsTo(DataHari::class,'nama_hari', 'nama_hari' );
    }
}
