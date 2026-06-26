<?php

namespace App\Jobs;

use App\Models\TrafficData;
use App\Models\TrafficHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class FetchTrafficJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $response = Http::timeout(5)->get('http://localhost:5000/api/traffic');

            if (!$response->ok()) {
                return;
            }

            $data = $response->json('data');

            foreach ($data as $item) {
                // 1. Update data terbaru/current per CCTV
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

                // 2. Tentukan window 30 detik
                $now = now();

                $second = $now->second < 30 ? 0 : 30;

                $windowStart = $now->copy()
                    ->setSecond($second)
                    ->setMicrosecond(0);

                $windowEnd = $windowStart->copy()->addSeconds(30);

                // 3. Ambil max sebelumnya dalam window yang sama
                $existingMax = TrafficHistory::where('key', $item['key'])
                    ->where('window_start', $windowStart)
                    ->value('max_total_kendaraan') ?? 0;
                $congestionScore = match ($item['status']) {
                    'Lancar' => 20,
                    'Ramai Lancar' => 45,
                    'Padat Merayap' => 70,
                    'Macet Total' => 90,
                    default => 0,
                };

                $existingMaxScore = TrafficHistory::where('key', $item['key'])
                    ->where('window_start', $windowStart)
                    ->value('max_congestion_score') ?? 0;
                // 4. Simpan/update history per 30 detik
                TrafficHistory::updateOrCreate(
                    [
                        'key'          => $item['key'],
                        'window_start' => $windowStart,
                    ],
                    [
                        'nama'       => $item['nama'],
                        'window_end' => $windowEnd,

                        // Untuk sekarang masih snapshot terbaru dalam window.
                        // Nanti bisa kita upgrade jadi average asli.
                        'avg_total_kendaraan' => $item['total_kendaraan'],
                        'avg_motor'           => $item['detail']['motor'],
                        'avg_mobil'           => $item['detail']['mobil'],
                        'avg_bus'             => $item['detail']['bus'],
                        'avg_truk'            => $item['detail']['truk'],

                        'max_total_kendaraan' => max($item['total_kendaraan'], $existingMax),

                        'dominant_status' => $item['status'],
                        'peak_status'     => $item['status'],

                        'avg_congestion_score' => $congestionScore,
                        'max_congestion_score' => max($congestionScore, $existingMaxScore),
                    ]
                );
            }
        } catch (\Exception $e) {
            logger()->error('FetchTrafficJob error: ' . $e->getMessage());
        } finally {
            // Dispatch dirinya sendiri lagi setelah 5 detik
            self::dispatch()->delay(now()->addSeconds(5));
        }
    }
}
