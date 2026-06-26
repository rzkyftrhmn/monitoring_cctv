<?php

namespace App\Http\Controllers;

use App\Models\TrafficData;
use App\Models\TrafficHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TrafficController extends Controller
{
    // Dipanggil oleh scheduler untuk fetch data dari Python
    public function fetchFromPython()
    {
        try {
            $response = Http::timeout(5)->get('http://localhost:5000/api/traffic');

            if (!$response->ok()) {
                return false;
            }

            $data = $response->json('data');

            foreach ($data as $item) {
                TrafficData::updateOrCreate(
                    ['key' => $item['key']],
                    [
                        'nama'            => $item['nama'],
                        'status'          => $item['status'],
                        'total_kendaraan' => $item['total_kendaraan'],
                        'motor'           => $item['detail']['motor'],
                        'mobil'           => $item['detail']['mobil'],
                        'bus'             => $item['detail']['bus'],
                        'truk'            => $item['detail']['truk'],
                        'waktu_update'    => $item['waktu_update'],
                    ]
                );
            }

            return true;

        } catch (\Exception $e) {
            return false;
        }
    }

    // Dipanggil oleh dashboard untuk ambil data dari DB
    public function index()
    {
        $data = TrafficData::all();
        return view('dashboard', compact('data'));
    }

    // Dipanggil dashboard untuk ambil data JSON (untuk polling)
    public function apiIndex()
    {
        $data = TrafficData::all();

        $latestUpdate = TrafficData::max('updated_at');

        $dataDelaySeconds = $latestUpdate
            ? now()->diffInSeconds($latestUpdate)
            : null;

        return response()->json([
            'success' => true,
            'data' => $data,
            'meta' => [
                'server_time' => now()->format('Y-m-d H:i:s'),
                'latest_update' => $latestUpdate,
                'data_delay_seconds' => $dataDelaySeconds,
                'ai_online' => $dataDelaySeconds !== null && $dataDelaySeconds <= 15,
            ],
        ]);
    }

    public function history(Request $request, $key)
    {
        $minutes = $request->query('minutes', 30);

        $histories = TrafficHistory::where('key', $key)
            ->where('window_start', '>=', now()->subMinutes($minutes))
            ->orderBy('window_start')
            ->get([
                'window_start',
                'avg_total_kendaraan',
                'avg_motor',
                'avg_mobil',
                'avg_bus',
                'avg_truk',
                'dominant_status',
                'avg_congestion_score',
            ]);

        return response()->json([
            'success' => true,
            'key' => $key,
            'data' => $histories,
        ]);
    }
}
