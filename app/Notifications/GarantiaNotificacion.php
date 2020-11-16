<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Garantia;
use App\Usuario;
use DateTime;

class GarantiaNotificacion extends Notification
{
    use Queueable;

    public $garantia = null;
    public $usuario = null;
    public $tipo = null;
    public $motivo = null;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Garantia $garantia, Usuario $usuario, int $tipo, string $motivo = null)
    {
        $this->garantia = $garantia;
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
        //1-Morosidad
        //2-Recordar pago
        //3-Informar pago
        //4-Problema con pago
        switch($this->tipo) {
            case 1:
                $titulo = '¡Ojo! presentas morisidad en el pago de la garantía';
                $mensaje = 'Por favor ponte al día con el pago de la garantía, recuerda que serás evaluado por tu nivel de cumplimiento.';
            break;
            case 2: 
                $fecha = new \DateTime($this->garantia->fechaCompromiso);
                $titulo = 'Recuerda pagar la garantía a tiempo';
                $mensaje = 'Recuerda informar tu pago de la garantía a más tardar el '.$fecha->format('d-m-Y').' para evitar morosidades.';
            break;
            case 3:
                $titulo = $this->usuario->primerNombre.' acába de reportar el pago de la garantía';
                $mensaje = 'Nos complace informarte que '.$this->usuario->primerNombre.' '.$this->usuario->primerApellido.' acaba de reportar su pago de la garantía';
                if($this->garantia->diasRetraso <= 0) {
                    $mensaje .= ' sin morosidad.';
                } else {
                    $mensaje .= ' con '.$this->garantia->diasRetraso.' '.($this->garantia->diasRetraso > 1 ? 'días' : 'día').' de retraso.';
                }
                $mensaje .= ' Por favor verifícalo, recuerda que tienes hasta 3 días para reportar problemas con su pago.';
            break;
            case 4:
                $fechaCompromiso = new \DateTime($this->garantia->fechaCompromiso);
                $fechaActual = new \DateTime();
                $intervalo = $fechaCompromiso->diff($fechaActual);
                $dias = (int)$intervalo->format('%R%a');
                $titulo = 'Exite un problema con tu pago';
                $mensaje = $this->usuario->primerNombre.' '.$this->usuario->primerApellido.' nos informa que tuvo un problema con tu pago de la garantía indicando lo siguiente: "'.$this->motivo.'", por favor envíale un nuevo comprobante';
                if($dias <= 0) {
                    $mensaje .= ' a más tardar el '.$fechaCompromiso->format('d-m-Y').' para evitar morosidades en el pago.';
                } else {
                    $mensaje .= ', ten en cuenta que ya presentas morosidad en el pago de la garantía y esto afectará tu evaluación de cumplimiento.';
                }
            break;
            default: break;
        };
        return [
            'usuario' => $this->usuario->rut,
            'garantia' => $this->garantia->idArriendo,
            'tipo' => $this->tipo,
            'titulo' => $titulo,
            'mensaje' => $mensaje
        ];
    }
}
