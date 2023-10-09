<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTindakanLab extends Model
{
    use HasFactory;
    protected $table = 'data_tindakan_lab';
    protected $fillable = [
        'id_tindakan',
        'id_lab',
        'nama_tindakan',
        'harga_tindakan',
    ];

    public function lab(){
        return $this->hasMany(DataLab::class, 'id_lab', 'id_lab');
    }
}
