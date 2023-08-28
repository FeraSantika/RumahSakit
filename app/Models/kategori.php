<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    use HasFactory;
    public $table = 'kategori';
    protected $fillable=[
        'kode_kategori',
        'nama_kategori'
    ];

    public function obat(){
        return $this->hasMany(DataObat::class, 'kode_kategori', 'kode_kategori');
    }
}
