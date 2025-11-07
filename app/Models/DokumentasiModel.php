<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumentasiModel extends Model
{
    use HasFactory;
    protected $table = 'dokumentasi';
    protected $fillable = [
        'paket_id',
        'file_path',
    ];
}
