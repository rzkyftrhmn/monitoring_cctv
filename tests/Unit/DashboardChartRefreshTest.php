<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class DashboardChartRefreshTest extends TestCase
{
    public function test_history_charts_are_periodically_refreshed(): void
    {
        $dashboard = file_get_contents(dirname(__DIR__, 2) . '/resources/views/dashboard.blade.php');

        $this->assertMatchesRegularExpression(
            '/setInterval\(\s*\(\)\s*=>\s*\{[^}]*loadTrafficHistoryChart[^}]*loadCongestionHistoryChart/s',
            $dashboard
        );
    }
}
