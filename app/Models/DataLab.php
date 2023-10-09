<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataLab extends Model
{
    use HasFactory;
    protected $table = 'data_lab';
    protected $fillable = [
        'id_lab',
        'nama_lab',
    ];
}
