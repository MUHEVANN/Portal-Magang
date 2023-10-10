<?php

namespace App\Console;

use App\Jobs\konfirmedDayJob;
use App\Models\Carrer;
use App\Models\Konfirmed;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('php ')->hourly();
        $schedule->call(function () {
            $carrer = Carrer::latest()->first()->id;
            $konfirmed = Konfirmed::with('user')->where('carrer_id', $carrer)->where('isSend', 0)->get();
            if (count($konfirmed) > 0) {
                foreach ($konfirmed as $konfirm) {
                    $konfirm_at = $konfirm->created_at;
                    $sixtyDays = $konfirm_at->addMinutes(60);
                    if (now()->diffInDays($sixtyDays) === 0) {
                        konfirmedDayJob::dispatch($konfirm);
                        $konfirm->isSend = 1;
                        $konfirm->save();
                    }
                }
            }
        });
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
