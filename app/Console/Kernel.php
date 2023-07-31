<?php

namespace App\Console;

use App\Console\Commands\AdUpdateDate;
use App\Console\Commands\AppOptimizeClear;
use App\Console\Commands\FifteenMinutesAuctionExpireNotification;
use App\Console\Commands\ImportDB;
use App\Console\Commands\OneDayAuctionExpireNotification;
use App\Console\Commands\OneHoursAuctionExpireNotification;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        AppOptimizeClear::class,
        AdUpdateDate::class,
        ImportDB::class,
        FifteenMinutesAuctionExpireNotification::class,
        OneHoursAuctionExpireNotification::class,
        OneDayAuctionExpireNotification::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:fifteen-minutes-expire-auction')
            ->everyMinute();

        $schedule->command('app:one-hours-expire-auction')
            ->everyMinute();

        $schedule->command('app:one-day-expire-auction')
            ->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     */
    protected function commands(): void
    {
        require base_path('routes/console.php');
    }
}
