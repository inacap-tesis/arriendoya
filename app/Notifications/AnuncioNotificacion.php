<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Anuncio;
use App\Usuario;

class AnuncioNotificacion extends Notification
{
    use Queueable;

    public $anuncio = null;
    public $usuario = null;
    public $tipo = null;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Anuncio $anuncio, Usuario $usuario, int $tipo)
    {
        $this->anuncio = $anuncio;
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
        //1-Interes
        //2-Desinteres
        //3-Rechazado
        //4-Seleccionado
        //5-No seleccionado
        //6-No disponible
        switch($this->tipo) {
            case 1:
                $titulo = '¡Alguien está interesado en tu anuncio!';
                $mensaje = $this->usuario->primerNombre.' '.$this->usuario->primerApellido.' está interesado en tu '.$this->anuncio->inmueble->tipo->nombre.', que está en '.$this->anuncio->inmueble->calleDireccion.' '.$this->anuncio->inmueble->numeroDireccion.' - '.$this->anuncio->inmueble->comuna->nombre;
            break;
            case 2: 
                $titulo = 'Alguien ya no está interesado en tu anuncio';
                $mensaje = $this->usuario->primerNombre.' '.$this->usuario->primerApellido.' ya no está interesado en tu '.$this->anuncio->inmueble->tipo->nombre.', que está en '.$this->anuncio->inmueble->calleDireccion.' '.$this->anuncio->inmueble->numeroDireccion.' - '.$this->anuncio->inmueble->comuna->nombre;
            break;
            case 3:
                $titulo = 'Ya no estás considerado en la lista de interesados de un anuncio';
                $mensaje = 'Lamentamos informarte que ya no estás considerado en la lista de interesados sobre el anuncio de '.$this->anuncio->inmueble->tipo->nombre.', que está en '.$this->anuncio->inmueble->calleDireccion.' '.$this->anuncio->inmueble->numeroDireccion.' - '.$this->anuncio->inmueble->comuna->nombre.'. Te recomendamos cargar los antecedentes requeridos que mencionan los anuncios.';
            break;
            case 4:
                $titulo = '¡Fuiste seleccionado como potencial inquilino en un anuncio!';
                $mensaje = 'Fuiste seleccionado como potencial inquilino en el anuncio de '.$this->anuncio->inmueble->tipo->nombre.', que está en '.$this->anuncio->inmueble->calleDireccion.' '.$this->anuncio->inmueble->numeroDireccion.' - '.$this->anuncio->inmueble->comuna->nombre;
            break;
            case 5:
                $titulo = 'Ya no estás considerado como potencial inquilino de un anuncio';
                $mensaje = 'Lamentamos informarte que ya no estás considerado como potencial inquilino sobre el anuncio de '.$this->anuncio->inmueble->tipo->nombre.', que está en '.$this->anuncio->inmueble->calleDireccion.' '.$this->anuncio->inmueble->numeroDireccion.' - '.$this->anuncio->inmueble->comuna->nombre.'. Te recomendamos cargar los antecedentes requeridos que mencionan los anuncios.';
            break;
            case 6:
                $titulo = 'Un anuncio ya no está disponible';
                $mensaje = 'Lamentamos informarte que el anuncio de '.$this->anuncio->inmueble->tipo->nombre.', que está en '.$this->anuncio->inmueble->calleDireccion.' '.$this->anuncio->inmueble->numeroDireccion.' - '.$this->anuncio->inmueble->comuna->nombre.' y del cual estabas interesado, ya no está disponible.';
            break;
            default: break;
        };
        return [
            'usuario' => $this->usuario->rut,
            'anuncio' => $this->anuncio->idInmueble,
            'tipo' => $this->tipo,
            'titulo' => $titulo,
            'mensaje' => $mensaje
        ];
    }
}
