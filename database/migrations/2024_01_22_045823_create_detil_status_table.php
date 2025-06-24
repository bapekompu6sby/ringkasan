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
        Schema::create('detil_status', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('id_status')->references('id')->on('status');
            $table->string('id_kegiatan_tahapan')->references('id')->on('kegiatan_tahapan');
            $table->string('file');
            $table->string('keterangan');
            $table->text('komentar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detil_status');
    }
};
