<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class DataUser extends Authenticatable
{
    use HasFactory;
    protected $table = 'data_user';
    protected $fillable = [
        'User_id',
        'User_name',
        'User_email',
        'User_password',
        'User_gender',
        'User_photo',
        'Role_id',
        'User_token',
    ];

    public function getAuthPassword(){
        return $this->User_password;
    }

    public function getAuthIdentifierName(){
        return "User_name";
    }

    public function getAuthIdentifier(){
        return $this->User_name;
    }

    public function role(){
        return $this->belongsTo(DataRole::class, 'Role_id', 'Role_id');
    }

    public function transaksibarangkeluar(){
        return $this->hasMany(Transaksi_barang_keluar::class, 'kode_kasir', 'User_id');
    }

}
