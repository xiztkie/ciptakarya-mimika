<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyncdataModel extends Model
{
    use HasFactory;
    protected $table = 'syncdata';
    protected $fillable = [
        'nama_api',
        'route_sync',
        'last_synced_at',
    ];
}
