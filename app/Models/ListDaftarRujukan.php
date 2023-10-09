<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListDaftarRujukan extends Model
{
    use HasFactory;
    protected $table = 'list_daftar_rujukan_pasien';
    protected $fillable = [
        'list_id',
        'kode_pendaftaran',
        'id_lab',
        'status',
        'keterangan',
        'tindakan',
        'filerujukan'
    ];

    public function daftar()
    {
        return $this->belongsTo(PendaftaranPasien::class, 'kode_pendaftaran', 'kode_pendaftaran');
    }

    public function lab()
    {
        return $this->belongsTo(DataLab::class, 'id_lab', 'id_lab');
    }

    public function tindakanlab()
    {
        return $this->belongsTo(DataTindakanLab::class, 'tindakan', 'id_tindakan');
    }

    public function akseslab()
    {
        return $this->belongsTo(DataAksesLab::class, 'id_lab', 'id_lab');
    }
}
