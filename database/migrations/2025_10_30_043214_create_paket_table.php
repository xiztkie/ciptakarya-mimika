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
        Schema::create('paket', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_anggaran', 4);
            $table->string('kd_rup');
            $table->string('kd_tender')->nullable();
            $table->string('kd_nontender')->nullable();
            $table->string('kd_satker_str')->nullable();
            $table->text('nama_satker')->nullable();
            $table->text('nama_paket')->nullable();
            $table->decimal('pagu', 20, 2)->nullable();
            $table->decimal('hps', 20, 2)->nullable();
            $table->string('sumber_dana')->nullable();
            $table->string('metode_pemilihan')->nullable();
            $table->string('jenis_pengadaan')->nullable();
            $table->text('nip_nama_ppk')->nullable();
            $table->string('status_tender')->nullable();
            $table->string('status_nontender')->nullable();
            $table->string('kategori')->nullable();
            $table->string('jenis')->nullable();
            $table->string('umur')->nullable();
            $table->string('detail_lokasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket');
    }
};
