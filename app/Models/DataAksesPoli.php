<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class data_akses_poli extends Model
{
    use HasFactory;
    protected $table = 'data_akses_poli';
    protected $fillable = [
        'id_akses_poli',
        'id_poli',
        'id_user'
    ];
}
