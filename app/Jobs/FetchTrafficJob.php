<?php

namespace App\Jobs;

use App\Models\TrafficData;
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

            if ($response->ok()) {
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
            }

        } catch (\Exception $e) {
            // Python belum jalan atau tidak bisa diakses
        } finally {
            // Dispatch dirinya sendiri lagi setelah 5 detik
            self::dispatch()->delay(now()->addSeconds(5));
        }
    }
}
