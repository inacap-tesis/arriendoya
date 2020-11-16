<?php

namespace App\Http\Controllers;

use App\Notifications\GarantiaNotificacion;
use Illuminate\Http\Request;
use App\Garantia;

class GarantiaController extends Controller
{

    public static function recordarPago(Garantia $garantia) {
        //Notificar al inquilino
        $garantia->arriendo->inquilino->notify(new GarantiaNotificacion($garantia, $garantia->arriendo->inmueble->propietario, 2));
    }

    public static function informarMorosidad(Garantia $garantia) {
        //Notificar al inquilino
        $garantia->arriendo->inquilino->notify(new GarantiaNotificacion($garantia, $garantia->arriendo->inmueble->propietario, 1));
    }

}
