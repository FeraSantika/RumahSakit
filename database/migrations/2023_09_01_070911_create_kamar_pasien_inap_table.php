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
        Schema::create('kamar_pasien_inap', function (Blueprint $table) {
            $table->bigIncrements('id_kamar_pasieninap');
            $table->date('tanggal_masuk');
            $table->date('tanggal_keluar');
            $table->integer('id_kamar_inap');
            $table->char('kode_pendaftaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kamar_pasien_inap');
    }
};
