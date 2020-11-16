<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\SolicitudFinalizacion;
use App\Usuario;

class SolicitudFinalizacionNotificacion extends Notification
{
    use Queueable;

    public $solicitud = null;
    public $usuario = null;
    public $tipo = null;
    public $motivo = null;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(SolicitudFinalizacion $solicitud, Usuario $usuario, int $tipo, string $motivo = null)
    {
        $this->solicitud = $solicitud;
        $this->usuario = $usuario;
        $this->tipo = $tipo;
        $this->motivo = $motivo;
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
        $fecha = new \DateTime($this->solicitud->fechaPropuesta);
        //1-Solicitud
        //2-Respuesta
        switch($this->tipo) {
            case 1:
                $titulo = $this->usuario->primerNombre.' quiere adelantar la finalización del arriendo';
                $mensaje = $this->usuario->primerNombre.' '.$this->usuario->primerApellido.' propone finalizar el arriendo el día '.$fecha->format('d-m-Y').' con la siguiente justificación: "'.$this->motivo.'", por favor responde su solicitud.';
            break;
            case 2: 
                if($this->solicitud->respuesta) {
                    $titulo = $this->usuario->primerNombre.' aceptó tu solicitud de finalización';
                    $mensaje = 'Nos complace informarte que '.$this->usuario->primerNombre.' '.$this->usuario->primerApellido.' aceptó finalizar el arriendo el día '.$fecha->format('d-m-Y').'.';
                } else {
                    $titulo = $this->usuario->primerNombre.' rechazó tu solicitud de finalización';
                    $mensaje = 'Lamentamos informarte que '.$this->usuario->primerNombre.' '.$this->usuario->primerApellido.' rechazó finalizar el arriendo el día '.$fecha->format('d-m-Y').', recuerda que todavía puedes solicitarlo nuevamente proponiendo una fecha distinta o finalizar el arriendo forzosamente aunque no lo recomendamos.';
                }
            break;
            default: break;
        };
        return [
            'usuario' => $this->usuario->rut,
            'solicitud' => $this->solicitud->id,
            'tipo' => $this->tipo,
            'titulo' => $titulo,
            'mensaje' => $mensaje
        ];
    }
}
