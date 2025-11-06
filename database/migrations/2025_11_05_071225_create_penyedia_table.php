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
        Schema::create('penyedia', function (Blueprint $table) {
            $table->id();
            $table->text('kd_penyedia')->nullable();
            $table->text('nama_penyedia')->nullable();
            $table->text('npwp_penyedia')->unique();
            $table->text('bentuk_usaha')->nullable();
            $table->text('alamat')->nullable();
            $table->text('kabupaten')->nullable();
            $table->text('provinsi')->nullable();
            $table->text('kodepos')->nullable();
            $table->text('telepon')->nullable();
            $table->text('fax')->nullable();
            $table->text('email')->nullable();
            $table->text('website')->nullable();
            $table->text('nomor_pkp')->nullable();
            $table->text('status_npwp')->nullable();
            $table->text('status_kswp')->nullable();
            $table->text('status_pelaku_usaha')->nullable();
            $table->text('alamat_pusat')->nullable();
            $table->text('telepon_pusat')->nullable();
            $table->text('fax_pusat')->nullable();
            $table->text('email_pusat')->nullable();
            $table->timestamp('tgl_daftar_sikap')->nullable();
            $table->timestamp('tgl_persetujuan_verifikasi_daftar_sikap')->nullable();
            $table->text('setuju_publikasi_data')->nullable();
            $table->text('npwp16_penyedia')->nullable();
            $table->boolean('oap')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyedia');
    }
};
