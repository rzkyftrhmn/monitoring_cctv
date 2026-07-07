<?php

namespace Tests\Feature;

use App\Models\TrafficHistory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class TrafficHistoryWindowTest extends TestCase
{
    use RefreshDatabase;

    public function test_history_returns_only_completed_windows_from_the_last_30_minutes(): void
    {
        Carbon::setTestNow('2026-07-07 10:01:10');

        TrafficHistory::create([
            'key' => 'cam-1',
            'nama' => 'Camera 1',
            'window_start' => '2026-07-07 09:31:00',
            'window_end' => '2026-07-07 09:31:30',
            'avg_total_kendaraan' => 10,
        ]);

        TrafficHistory::create([
            'key' => 'cam-1',
            'nama' => 'Camera 1',
            'window_start' => '2026-07-07 10:00:30',
            'window_end' => '2026-07-07 10:01:00',
            'avg_total_kendaraan' => 20,
        ]);

        TrafficHistory::create([
            'key' => 'cam-1',
            'nama' => 'Camera 1',
            'window_start' => '2026-07-07 10:01:00',
            'window_end' => '2026-07-07 10:01:30',
            'avg_total_kendaraan' => 30,
        ]);

        $response = $this->getJson('/api/traffic-history/cam-1?minutes=30');

        $response->assertOk()
            ->assertJsonPath('data.0.avg_total_kendaraan', 10)
            ->assertJsonPath('data.1.avg_total_kendaraan', 20)
            ->assertJsonCount(2, 'data');
    }
}
