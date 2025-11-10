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
            $table->string('kd_rup')->unique();
            $table->unsignedSmallInteger('tahun_anggaran')->index();
            $table->string('kd_tender')->nullable();
            $table->string('kd_nontender')->nullable();
            $table->string('kd_satker_str')->nullable();
            $table->text('nama_satker')->nullable();
            $table->text('nama_paket')->nullable();
            $table->decimal('pagu', 20, 2)->nullable();
            $table->decimal('hps', 20, 2)->nullable();
            $table->text('sumber_dana')->nullable();
            $table->text('metode_pengadaan')->nullable();
            $table->text('jenis_pengadaan')->nullable();
            $table->text('nama_ppk')->nullable();
            $table->text('nip_ppk')->nullable();
            $table->text('status_tender')->nullable();
            $table->text('status_nontender')->nullable();
            $table->text('kategori')->nullable();
            $table->text('jenis')->nullable();
            $table->text('umur')->nullable();
            $table->text('detail_lokasi')->nullable();
            $table->string('bidang')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->text('keterangan')->nullable();
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
