<?php

namespace App\Providers;

use App\Jobs\FetchTrafficJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Dispatch job hanya jika belum ada job yang sama di queue
        $queue = DB::table('jobs')
            ->where('payload', 'like', '%FetchTrafficJob%')
            ->exists();

        if (!$queue) {
            FetchTrafficJob::dispatch();
        }
    }
}
