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

    private function statusToScore(?string $status): int
    {
        return match ($status) {
            'Lancar' => 20,
            'Ramai Lancar' => 45,
            'Padat Merayap' => 70,
            'Macet Total' => 90,
            default => 0,
        };
    }

    private function getTrendLabel(float $change): string
    {
        if ($change >= 20) {
            return 'Memburuk Cepat';
        }

        if ($change >= 8) {
            return 'Memburuk';
        }

        if ($change <= -20) {
            return 'Membaik Cepat';
        }

        if ($change <= -8) {
            return 'Membaik';
        }

        return 'Stabil';
    }

    private function getPriorityLabel(float $score): string
    {
        if ($score >= 75) {
            return 'Tinggi';
        }

        if ($score >= 50) {
            return 'Sedang';
        }

        return 'Rendah';
    }

    private function getReason(string $priority, string $trend, float $changeScore, string $status): string
    {
        if ($trend === 'Memburuk Cepat') {
            return 'Tren kemacetan meningkat cepat dalam 30 menit terakhir.';
        }

        if ($trend === 'Memburuk') {
            return 'Tren kemacetan meningkat dalam 30 menit terakhir.';
        }

        if ($priority === 'Tinggi') {
            return "Kondisi saat ini berada pada level {$status} dan perlu dipantau lebih dulu.";
        }

        if ($changeScore < 0) {
            return 'Tren 30 menit terakhir membaik, tetapi kondisi tetap perlu dimonitor.';
        }

        return 'Tidak ada kenaikan signifikan dalam 30 menit terakhir.';
    }

    private function getRecommendation(string $priority, string $trend, string $status): string
    {
        if ($priority === 'Tinggi') {
            return 'Prioritaskan pemantauan lokasi ini dan evaluasi pengaturan arus.';
        }

        if ($trend === 'Memburuk Cepat' || $trend === 'Memburuk') {
            return 'Pantau lebih sering untuk mencegah penumpukan kendaraan.';
        }

        if ($status === 'Lancar') {
            return 'Kondisi terkendali. Tidak diperlukan tindakan khusus saat ini.';
        }

        return 'Pantau berkala dan bandingkan dengan tren 30 menit terakhir.';
    }

    private function buildPriorityPayload(TrafficData $current, int $minutes): array
    {
        $histories = TrafficHistory::where('key', $current->key)
            ->where('window_start', '>=', now()->subMinutes($minutes))
            ->orderBy('window_start')
            ->get();

        $firstHistory = $histories->first();
        $lastHistory = $histories->last();

        $firstScore = $firstHistory
            ? ($firstHistory->avg_congestion_score ?? $this->statusToScore($firstHistory->dominant_status))
            : $this->statusToScore($current->status);

        $lastScore = $lastHistory
            ? ($lastHistory->avg_congestion_score ?? $this->statusToScore($lastHistory->dominant_status))
            : $this->statusToScore($current->status);

        $currentScore = $this->statusToScore($current->status);
        $changeScore = round($lastScore - $firstScore, 2);
        $trend = $this->getTrendLabel($changeScore);

        // Konsisten dengan insight: kondisi saat ini dominan, tren memburuk menambah urgensi.
        $priorityScore = min(100, max(0, round(
            ($currentScore * 0.6) + (max($changeScore, 0) * 2)
        )));

        $priority = $this->getPriorityLabel($priorityScore);

        return [
            'key' => $current->key,
            'nama' => $current->nama,
            'current_status' => $current->status,
            'current_score' => $currentScore,
            'change_score' => $changeScore,
            'trend' => $trend,
            'priority_score' => $priorityScore,
            'priority' => $priority,
            'reason' => $this->getReason($priority, $trend, $changeScore, $current->status),
            'recommendation' => $this->getRecommendation($priority, $trend, $current->status),
            'window_minutes' => $minutes,
        ];
    }

    public function insight(Request $request, $key)
    {
        $minutes = (int) $request->query('minutes', 30);

        $current = TrafficData::where('key', $key)->first();

        if (!$current) {
            return response()->json([
                'success' => false,
                'message' => 'Data traffic tidak ditemukan',
            ], 404);
        }

        $payload = $this->buildPriorityPayload($current, $minutes);

        return response()->json([
            'success' => true,
        ] + $payload);
    }

    public function priorities(Request $request)
    {
        $minutes = (int) $request->query('minutes', 30);

        $data = TrafficData::all()
            ->map(fn (TrafficData $current) => $this->buildPriorityPayload($current, $minutes))
            ->sortByDesc('priority_score')
            ->values();

        return response()->json([
            'success' => true,
            'data' => $data,
            'window_minutes' => $minutes,
        ]);
    }
}
