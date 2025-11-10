<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyediaModel extends Model
{
    use HasFactory;
    protected $table = 'penyedia';
    protected $fillable = [
        'kd_penyedia',
        'nama_penyedia',
        'npwp_penyedia',
        'bentuk_usaha',
        'alamat',
        'kabupaten',
        'provinsi',
        'kodepos',
        'telepon',
        'fax',
        'email',
        'website',
        'nomor_pkp',
        'status_npwp',
        'status_kswp',
        'status_pelaku_usaha',
        'alamat_pusat',
        'telepon_pusat',
        'fax_pusat',
        'email_pusat',
        'tgl_daftar_sikap',
        'tgl_persetujuan_verifikasi_daftar_sikap',
        'setuju_publikasi_data',
        'npwp16_penyedia',
        'oap'
    ];
}
