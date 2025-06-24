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
        Schema::create('pelatihan', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('nama');
            $table->string('id_jenis')->references('id')->on('jenis_pelatihan');
            $table->string('id_bidang')->references('id')->on('bidang_pelatihan');
            $table->string('id_model')->references('id')->on('model_pelatihan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->year('tahun_periode');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelatihan');
    }
};
