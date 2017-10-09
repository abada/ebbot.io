<?php

namespace App\Console;

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
        // BACKFILL
        Commands\BackfillDeploymentDuration::class,
        
        // METRICS
        Commands\MetricsDay::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $env = config('app.env');
        
        $schedule->command('spark:kpi')->daily()
            ->pingBefore("https://envbeat.com/ping/B0BXW8hOn84stxrkrX0e?env={$env}")
            ->thenPing("https://envbeat.com/ping/B0BXW8hOn84stxrkrX0e?env={$env}&ended");
            
        $schedule->command('metrics:day')->daily()
            ->pingBefore("https://envbeat.com/ping/lHud6gQtS77KH2m3zFup?env={$env}")
            ->thenPing("https://envbeat.com/ping/lHud6gQtS77KH2m3zFup?env={$env}&ended");
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
