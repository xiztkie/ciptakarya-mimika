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
        Schema::create('kontrak', function (Blueprint $table) {
            $table->id();
            $table->year('tahun_anggaran');
            $table->text('kd_rup');
            $table->text('kd_tender')->nullable();
            $table->text('kd_nontender')->nullable();
            $table->text('no_kontrak')->nullable();
            $table->date('tgl_kontrak')->nullable();
            $table->decimal('nilai_kontrak', 20, 2)->nullable();
            $table->decimal('nilai_penawaran', 20, 2)->nullable();
            $table->text('waktu_pelaksanaan')->nullable();
            $table->text('nama_penyedia')->nullable();
            $table->text('npwp_penyedia')->nullable();
            $table->text('wakil_sah_penyedia')->nullable();
            $table->boolean('oap')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontrak');
    }
};
