<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\SolicitudFinalizacion;
use App\Arriendo;
use App\Http\Controllers\DeudaController;
use App\Notifications\SolicitudFinalizacionNotificacion;

class SolicitudFinalizacionController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function registrar(Request $request) {
        $solicitud = new SolicitudFinalizacion();
        $arriendo = Arriendo::find($request->id);
        $solicitud->idArriendo = $arriendo->id;
        $solicitud->rutEmisor = Auth::user()->rut;
        $solicitud->fechaPropuesta = $request->fecha;
        $solicitud->respuesta = null;
        $solicitud->estado = true;
        if(Auth::user()->rut == $arriendo->inquilino->rut) {
            $solicitud->rutReceptor = $arriendo->inmueble->propietario->rut;
            $solicitud->save();
            //Notificar al propietario
            $arriendo->inmueble->propietario->notify(new SolicitudFinalizacionNotificacion($solicitud, $arriendo->inquilino, 1, $request->motivo));
        } else {
            $solicitud->rutReceptor = $arriendo->inquilino->rut;
            $solicitud->save();
            //Notificar al inquilino
            $arriendo->inquilino->notify(new SolicitudFinalizacionNotificacion($solicitud, $arriendo->inmueble->propietario, 1, $request->motivo));
        }

        return $arriendo->id;
    }

    public function responder(Request $request) {
        $solicitud = SolicitudFinalizacion::find($request->id);
        if($request->respuesta == 'true') {
            $solicitud->respuesta = true;
            $solicitud->estado = false;
            $solicitud->arriendo->fechaTerminoPropuesta = $solicitud->fechaPropuesta;
            $solicitud->arriendo->fechaTerminoReal = $solicitud->fechaPropuesta;
            $solicitud->arriendo->save();
            //Actualizar las deudas
            DeudaController::modificarPeriodo($solicitud->arriendo);
        } else {
            $solicitud->respuesta = false;
        }
        $solicitud->save();
        //Notificar respuesta al usuario
        $solicitud->emisor->notify(new SolicitudFinalizacionNotificacion($solicitud, $solicitud->receptor, 2));
        return $solicitud->arriendo->id;
    }
    
}
