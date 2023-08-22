<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataObat extends Model
{
    use HasFactory;
    public $table = 'data_obat';
    protected $fillable = [
        'kode_obat',
        'kode_kategori',
        'nama_obat',
        'harga_jual',
        'diskon_obat',
        'stok_obat'
    ];

    public function kategori()
    {
        return $this->belongsTo(kategori::class, 'kode_kategori', 'kode_kategori');
    }
}
