<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\User;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
      //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
      $schedule->call(function () {
        $users = User::whereColumn('hp_max', '>', 'hp_current')->get();
        foreach ($users as $key => $user) {
          $user = User::where('id', $user->id)->first();
          $hp_max = $user->hp_max;
          $hp_current = $user->hp_current;
          $hp_regen = $user->hp_regen;
          if($hp_max - $hp_current < $hp_regen)
          {
            $hp_regen = $user->hp_max - $user->hp_current;
          }
          $user->increment('hp_current', $hp_regen);
          $user->save();
        }
      });
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
