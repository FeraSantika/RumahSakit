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
        Schema::create('data_rumah_sakit', function (Blueprint $table) {
            $table->bigIncrements('id_rumahsakit');
            $table->char('nama_rumahsakit');
            $table->char('alamat_rumahsakit');
            $table->char('logo_rumahsakit');
            $table->char('telp_rumahsakit');
            $table->char('email_rumahsakit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_rumah_sakit');
    }
};
