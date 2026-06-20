<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrafficData extends Model
{
    protected $table = 'traffic_data';

    protected $fillable = [
        'key',
        'nama',
        'status',
        'total_kendaraan',
        'motor',
        'mobil',
        'bus',
        'truk',
        'waktu_update',
    ];
}