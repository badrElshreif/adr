<?php

namespace App\Infrastructure\Console;

use App\Infrastructure\Console\Commands\RemoveFailedPayment;
use App\Infrastructure\Console\Commands\UpdateOrderStatusDelayed;
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
        RemoveFailedPayment::class,
        UpdateOrderStatusDelayed::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        $schedule->command('remove:failedpayment')->daily();
        $schedule->command('delivery:check')->everyTwoMinutes();
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
