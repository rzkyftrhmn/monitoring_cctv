<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrafficHistory extends Model
{
    protected $table = 'traffic_histories';

    protected $fillable = [
        'key',
        'nama',
        'window_start',
        'window_end',
        'avg_total_kendaraan',
        'avg_motor',
        'avg_mobil',
        'avg_bus',
        'avg_truk',
        'max_total_kendaraan',
        'dominant_status',
        'peak_status',
        'avg_congestion_score',
        'max_congestion_score',
    ];
}
