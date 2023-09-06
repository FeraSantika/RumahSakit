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
        Schema::create('list_daftar_tindakan_pasienInap', function (Blueprint $table) {
            $table->bigIncrements('list_id');
            $table->char('kode_pendaftaran');
            $table->char('nama_tindakan');
            $table->char('harga_tindakan');
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_daftar_tindakan_pasien_inap');
    }
};
