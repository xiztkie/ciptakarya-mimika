<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KontrakModel extends Model
{
    use HasFactory;
    protected $table = 'kontrak';
    protected $fillable = [
        'kd_rup',
        'kd_tender',
        'kd_nontender',
        'no_kontrak',
        'tgl_kontrak',
        'nilai_kontrak',
        'waktu_pelaksanaan',
        'nama_penyedia',
        'npwp_penyedia',
        'wakil_sah_penyedia',
    ];
}
