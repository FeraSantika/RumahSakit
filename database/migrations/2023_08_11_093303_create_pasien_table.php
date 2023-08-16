<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_pasien', function (Blueprint $table) {
            $table->bigIncrements('pasien_id');
            $table->char('pasien_kode');
            $table->integer('pasien_NIK');
            $table->char('pasien_nama');
            $table->char('pasien_tempat_lahir');
            $table->date('pasien_tgl_lahir');
            $table->enum('pasien_jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->char('pasien_alamat');
            $table->enum('pasien_agama', ['Islam', 'Kristen protestan', 'Kristen katolik', 'Hindu', 'Budha', 'Khonghucu']);
            $table->enum('pasien_status', ['Belum Kawin', 'Kawin']);
            $table->char('pasien_pekerjaan');
            $table->enum('pasien_kewarganegaraan', ['WNI', 'WNA']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasien');
    }
};
