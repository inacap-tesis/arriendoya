<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Calificacion;
use App\Usuario;

class CalificacionNotificacion extends Notification
{
    use Queueable;

    public $calificacion = null;
    public $usuario = null;
    public $tipo = null;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Calificacion $calificacion, Usuario $usuario, int $tipo)
    {
        $this->calificacion = $calificacion;
        $this->usuario = $usuario;
        $this->tipo = $tipo;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        //1-Por part del propietario
        //2-Por parte del inquilino
        //3-Por part del sistema
        switch($this->tipo) {
            case 1:
                $titulo = 'Acaban de calificarte';
                $mensaje = $this->usuario->primerNombre.' '.$this->usuario->primerApellido.' acaba de calificarte con un ['.$this->calificacion->notaAlInquilino.'], en base a su experiencia y comentó lo siguiente "'.$this->calificacion->comentarioAlInquilino.'"';
            break;
            case 2: 
                $titulo = 'Acaban de calificarte el arriendo';
                $mensaje = $this->usuario->primerNombre.' '.$this->usuario->primerApellido.' acaba de calificar el arriendo con un ['.$this->calificacion->notaAlInquilino.'], en base a su experiencia y comentó lo siguiente "'.$this->calificacion->comentarioAlInquilino.'"';
            break;
            case 3:
                $titulo = 'Acabamos de calificar tu niver de cumplimiento';
                $mensaje = 'De acuerdo a tu anterior arriendo de '.$this->calificacion->arriendo->inmueble->tipo->nombre.', que está en '.$this->calificacion->arriendo->inmueble->calleDireccion.' '.$this->calificacion->arriendo->inmueble->numeroDireccion.' - '.$this->calificacion->arriendo->inmueble->comuna->nombre.', tu nivel de cumplimiento en el pago de renta fue de ['.$this->calificacion->cumplimientoInquilino.']';
            break;
            default: break;
        };
        return [
            'usuario' => $this->usuario->rut,
            'calificacion' => $this->calificacion->idArriendo,
            'tipo' => $this->tipo,
            'titulo' => $titulo,
            'mensaje' => $mensaje
        ];
    }
}
