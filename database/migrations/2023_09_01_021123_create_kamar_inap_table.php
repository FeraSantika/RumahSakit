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
        Schema::create('data_kamar_inap', function (Blueprint $table) {
            $table->bigIncrements('id_kamar_inap');
            $table->char('nama_kamar_inap');
            $table->char('nomor_kamar_inap');
            $table->integer('harga_kamar_inap');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kamar_inap');
    }
};
