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
        Schema::create('list_daftar_rujukan_pasien_inap', function (Blueprint $table) {
            $table->bigIncrements('list_id');
            $table->char('kode_pendaftaran');
            $table->integer('id_lab');
            $table->enum('status', ['Belum tertangani', 'Tertangani']);
            $table->char('keterangan');
            $table->char('tindakan');
            $table->char('filerujukan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_daftar_rujukan_pasien_inap');
    }
};
