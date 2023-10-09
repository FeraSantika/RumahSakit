<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataHari extends Model
{
    use HasFactory;
    protected $table = 'data_hari';
    protected $fillable = [
        'id_hari',
        'nama_hari',
    ];
}
