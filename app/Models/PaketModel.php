<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketModel extends Model
{
    use HasFactory;
    protected $table = 'paket';
    protected $fillable = [
        'tahun_anggaran',
        'kd_rup',
        'kd_tender',
        'kd_nontender',
        'kd_satker_str',
        'nama_satker',
        'nama_paket',
        'pagu',
        'hps',
        'sumber_dana',
        'sub_sumberdana',
        'metode_pengadaan',
        'jenis_pengadaan',
        'nip_nama_ppk',
        'status_tender',
        'status_nontender',
        'kategori',
        'jenis',
        'umur',
        'detail_lokasi',
        'bidang',
        'longitude',
        'latitude',
        'keterangan',
    ];
}
