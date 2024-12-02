<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Attendance;
use App\Models\Shift;
use Carbon\Carbon;
use App\Models\Teacher;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            // Cek shift
            $shift = Shift::find(1);
            if (!$shift) {
                return;
            }

            // Cek waktu sekarang
            $currentTime = Carbon::now()->format('H:i:s');

            // Cek apakah ada guru yang belum absen dari jam sekarang hingga waktu akhir
            $absentTeachers = Teacher::whereDoesntHave('attendances', function ($query) use ($currentTime, $shift) {
                $query->where('hour_came', '>=', $currentTime)
                    ->where('hour_came', '<=', $shift->end_time);
            })->get();

            // Ubah status guru yang belum absen menjadi "Alpa"
            foreach ($absentTeachers as $teacher) {
                $attendance = new Attendance();
                $attendance->teacher_id = $teacher->teacher_id;
                $attendance->barcode = $teacher->barcode;
                $attendance->hour_came = null;
                $attendance->home_time = null;
                $attendance->status = 'Alpa';
                $attendance->save();
            }
        })->dailyAt('12:50');
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
