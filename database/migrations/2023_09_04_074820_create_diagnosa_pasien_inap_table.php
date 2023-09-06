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
        Schema::create('diagnosa_pasien_inap', function (Blueprint $table) {
            $table->bigIncrements('id_diagnosa_pasieninap');
            $table->char('kode_pendaftaran');
            $table->date('tanggal');
            $table->char('diagnosa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnosa_pasien_inap');
    }
};
