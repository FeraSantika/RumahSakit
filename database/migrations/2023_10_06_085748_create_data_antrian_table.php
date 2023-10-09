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
        Schema::create('data_antrian', function (Blueprint $table) {
            $table->bigIncrements('id_antrian');
            $table->integer('id_poli');
            $table->integer('nomor_antrian');
            $table->date('tanggal_antrian');
            $table->enum('status_antrian', [0,1]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_antrian');
    }
};
