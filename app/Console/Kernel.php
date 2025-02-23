<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\SyncEmailsJob;
use App\Http\Controllers\EmailSyncController;
use Illuminate\Support\Facades\Http;



class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            app(EmailSyncController::class)->syncEmails();
        })->everyMinute();
        $schedule->command('emails:sync')->everyMinute();

        $schedule->exec('curl https://femm.ro/sync-emails')->everyMinute();

        $schedule->call(function () {
            Http::get('https://femm.ro/sync-emails');
        })->everyMinute();

        $schedule->command('emails:sync')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
