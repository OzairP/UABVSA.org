<?php

namespace App\Console;

use App\Jobs\Lotus\PruneExpiredPendingReservations;
use App\Jobs\Nova\PruneOldHealthChecks;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Spatie\Health\Commands\RunHealthChecksCommand;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(RunHealthChecksCommand::class)->everyMinute();
        $schedule->command(PruneOldHealthChecks::class)->everySixHours();
        $schedule->command(PruneExpiredPendingReservations::class)->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
