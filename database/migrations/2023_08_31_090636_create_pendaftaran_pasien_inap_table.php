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
        Schema::create('pendaftaran_pasien_inap', function (Blueprint $table) {
            $table->bigIncrements('id_pendaftaran');
            $table->char('kode_pendaftaran');
            $table->integer('pasien_id');
            $table->text('keluhan');
            $table->date('tgl_daftar')->nullable();
            $table->enum('status_pasien', ['Umum', 'BPJS']);
            $table->text('diagnosa')->nullable();
            $table->text('petugas');
            $table->enum('status_pemeriksaan', ['Belum tertangani', 'Tertangani']);
            $table->enum('status_obat', ['Belum tertangani', 'Tertangani']);
            $table->integer('grandtotal');
            $table->integer('dibayar');
            $table->integer('kembalian');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_pasien_inap');
    }
};
