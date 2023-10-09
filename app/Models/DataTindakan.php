<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTindakan extends Model
{
    use HasFactory;
    protected $table = 'data_tindakan';
    protected $fillable = [
        'id_tindakan',
        'nama_tindakan',
        'harga_tindakan'
    ];
}
