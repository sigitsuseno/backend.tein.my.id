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
        Schema::create('informasi_medis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('golongan_darah')->nullable();
            $table->string('riwayat_penyakit')->nullable();
            $table->string('alergi')->nullable();
            $table->string('konsumsi_obat')->nullable();
            $table->string('tensi_darah')->nullable();
            $table->string('kondisi_medis_sekarang')->nullable();
            $table->unsignedBigInteger('vaksin_id')->nullable();
            $table->unsignedBigInteger('resep_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_medis');
    }
};
