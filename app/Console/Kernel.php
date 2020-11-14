<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Arriendo;
use App\Calificacion;
use DateTime;

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

            $fechaActual = new DateTime();

            foreach(Arriendo::where('estado', true)->get() as $arriendo) {
                
                $fecha = new DateTime($arriendo->fechaTerminoReal);

                //Finalizar arriendos que cumplan la fecha propuesta.
                if($fecha < $fechaActual) {
                    $arriendo->estado = false;
                    $arriendo->save();
                    $arriendo->inmueble->idEstado = 7;
                    $arriendo->inmueble->save();
                    $calificacion = new Calificacion();
                    $calificacion->idArriendo = $arriendo->id;
                    //Calcular nota al inquilino
                    $calificacion->cumplimientoInquilino = 0;
                    $calificacion->save();
                    //Enviar notificación a ambas partes
                    echo 'Finalizó el arriendo '.$arriendo->id. PHP_EOL;
                    continue;
                }

                $intervalo = $fechaActual->diff($fecha);
                $diasDiferencia = (int)$intervalo->format('%R%a');

                //Recordar pago de renta a inquilinos cuando la fecha de compromiso esté a 5 días de cumplirse.
                if($diasDiferencia < 6) {
                    //Enviar notificación
                }
                
                //Consultar por renovación de arriendo cuando esté a 30, 15, 5, 2 y un día antes de finalizar.
                if($diasDiferencia == 30 || $diasDiferencia == 15 || $diasDiferencia == 5 || $diasDiferencia < 3) {
                    if($arriendo->inquilino->notificaciones->where('idCategoria ', 15)->where('estado', true)->count() == 0) {
                        //Enviar notificación a inquilino
                    }
                    if($arriendo->inmueble->propietario->notificaciones->where('idCategoria ', 15)->where('estado', true)->count() == 0) {
                        //Enviar notificación a propietario
                    }
                }

                //Informar morosidad a los inquilinos cuando la fecha de compromiso de pagos sea menor que la fecha actual.
                $deuda = $arriendo->deudas->where('estado', false)->first();
                if($deuda) {
                    $fecha = new DateTime($deuda->fechaCompromiso);
                    if($fecha < $fechaActual){
                        //Enviar notificación
                    }
                }
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
