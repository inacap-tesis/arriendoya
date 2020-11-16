<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Arriendo;
use App\Usuario;
use DateTime;

class ArriendoNotificacion extends Notification
{
    use Queueable;

    public $arriendo = null;
    public $usuario = null;
    public $tipo = null;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Arriendo $arriendo, Usuario $usuario, int $tipo)
    {
        $this->arriendo = $arriendo;
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
        //1-Inicio
        //2-Consultar renovación
        //3-Finalización
        //4-Informar rechazo de renovación
        //5-Informar renovación
        switch($this->tipo) {
            case 1:
                if($this->arriendo->inquilino->rut != $this->usuario->rut) {
                    $titulo = '¡Felicitaciones! Acaba de empezar tu arriendo';
                    $mensaje = $this->usuario->primerNombre.' '.$this->usuario->primerApellido.' acaba de arrendarte su '.$this->arriendo->inmueble->tipo->nombre.', que está en '.$this->arriendo->inmueble->calleDireccion.' '.$this->arriendo->inmueble->numeroDireccion.' - '.$this->arriendo->inmueble->comuna->nombre.', recuerda ser cumplido en la fechas de pago.';
                } else {
                    $titulo = '¡Felicitaciones! Acabas de arrendar tu '.$this->arriendo->inmueble->tipo->nombre;
                    $mensaje = 'Nos complace informarte que acabas de arrendar tu '.$this->arriendo->inmueble->tipo->nombre.', que está en '.$this->arriendo->inmueble->calleDireccion.' '.$this->arriendo->inmueble->numeroDireccion.' - '.$this->arriendo->inmueble->comuna->nombre.' a '.$this->usuario->primerNombre.' '.$this->usuario->primerApellido;
                }
            break;
            case 2: 
                $fechaActual = new \DateTime();
                $fechaTermino = new \DateTime($this->arriendo->fechaTerminoReal);
                $intervalo = $fechaActual->diff($fechaTermino);
                $dias = (int)$intervalo->format('%R%a');
                $titulo = '¡Tu arriendo se renovará automáticamente!';
                if($dias == 0) {
                    $mensaje = 'Al término de hoy día, renovaremos automáticamente tu arriendo de '.$this->arriendo->inmueble->tipo->nombre.', que está en '.$this->arriendo->inmueble->calleDireccion.' '.$this->arriendo->inmueble->numeroDireccion.' - '.$this->arriendo->inmueble->comuna->nombre.'. Si no deseas que se renueve automáticamente, presiona el siguiente botón.';
                } else {
                    $mensaje = 'Estamos a '.$dias.' días de renovar automáticamente tu arriendo de '.$this->arriendo->inmueble->tipo->nombre.', que está en '.$this->arriendo->inmueble->calleDireccion.' '.$this->arriendo->inmueble->numeroDireccion.' - '.$this->arriendo->inmueble->comuna->nombre.'. Si no deseas que se renueve automáticamente, presiona el siguiente botón.';
                }
            break;
            case 3:
                $titulo = 'Arriendo finalizado';
                $mensaje = 'Tu arriendo de '.$this->arriendo->inmueble->tipo->nombre.', que está en '.$this->arriendo->inmueble->calleDireccion.' '.$this->arriendo->inmueble->numeroDireccion.' - '.$this->arriendo->inmueble->comuna->nombre.' acaba de finalizar, por favor recuerda realizar la calificación en base a tu experiencia.';
            break;
            case 4:
                $titulo = '';
                $mensaje = '';
            break;
            case 5:
                $titulo = '¡Felicitaciones! tu arriendo ha sido renovado';
                $mensaje = 'Tu arriendo de '.$this->arriendo->inmueble->tipo->nombre.', que está en '.$this->arriendo->inmueble->calleDireccion.' '.$this->arriendo->inmueble->numeroDireccion.' - '.$this->arriendo->inmueble->comuna->nombre.', ha sido renovado correctamente.';
            break;
            default: break;
        };
        return [
            'usuario' => $this->usuario->rut,
            'arriendo' => $this->arriendo->id,
            'tipo' => $this->tipo,
            'titulo' => $titulo,
            'mensaje' => $mensaje
        ];
    }
}
