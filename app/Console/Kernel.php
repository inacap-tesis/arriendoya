<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Arriendo;

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
            foreach(Arriendo::all() as $arriendo) {
                //Recordar pago de renta a inquilinos cuando la fecha de compromiso esté a x días de cumplirse.
                //Consultar por renovación de arriendo cuando esté a 30, 15, 5, 2 y un día antes de finalizar.
                //Finalizar arriendos que cumplan la fecha propuesta.
                echo $arriendo. PHP_EOL;
            }
        })->everyMinute(); //->daily();
        //$schedule->command('inspire')->hourly();
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
