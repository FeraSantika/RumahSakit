<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAksesPoli extends Model
{
    use HasFactory;
    protected $table = 'data_akses_poli';
    protected $fillable = [
        'id_akses_poli',
        'id_poli',
        'id_user'
    ];

    public function user(){
        return $this->belongsTo(DataUser::class,'id_user', 'User_id' );
    }

    public function poli(){
        return $this->belongsTo(DataPoli::class,'id_poli', 'id_poli' );
    }

    public function daftar(){
        return $this->hasMany(PendaftaranPasien::class,'id_poli', 'id_poli' );
    }
}
