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
        Schema::create('list_daftar_obat_pasien', function (Blueprint $table) {
            $table->bigIncrements('list_id');
            $table->char('kode_pasien');
            $table->char('nama_obat');
            $table->char('kategori_obat');
            $table->integer('qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_daftar_obat_pasien');
    }
};
