<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAksesLab extends Model
{
    use HasFactory;
    protected $table = 'data_akses_lab';
    protected $fillable = [
        'id_akses_lab',
        'id_lab',
        'id_user'
    ];

    public function user(){
        return $this->belongsTo(DataUser::class,'id_user', 'User_id' );
    }

    public function lab(){
        return $this->belongsTo(DataLab::class,'id_lab', 'id_lab' );
    }

    public function daftar(){
        return $this->hasMany(PendaftaranPasien::class,'id_poli', 'id_poli' );
    }
}
