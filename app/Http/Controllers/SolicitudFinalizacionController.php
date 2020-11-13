<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\SolicitudFinalizacion;
use App\Arriendo;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\DeudaController;

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
        if(Auth::user()->rut == $arriendo->inquilino->rut) {
            $solicitud->rutReceptor = $arriendo->inmueble->propietario->rut;
        } else {
            $solicitud->rutReceptor = $arriendo->inquilino->rut;
        }
        $solicitud->fechaPropuesta = $request->fecha;
        $solicitud->respuesta = null;
        $solicitud->save();

        //Generar notificación de tipo 13
        /*$notificacion = new Notificacion();
        $notificacion->rutUsuario = $solicitud->rutReceptor;
        $notificacion->idCategoria = 13;
        $notificacion->idReferencia = $solicitud->id;
        $notificacion->mensaje = $request->motivo;
        $notificacion->estado = true;
        $notificacion->save();*/

        return $arriendo->inmueble->id;
    }

    public function responder(Request $request) {
        $solicitud = SolicitudFinalizacion::find($request->id);
        if($request->respuesta == 'true') {
            $solicitud->respuesta = true;
            $solicitud->arriendo->fechaTerminoPropuesta = $solicitud->fechaPropuesta;
            $solicitud->arriendo->fechaTerminoReal = $solicitud->fechaPropuesta;
            $solicitud->arriendo->save();
            //Actualizar las deudas
            DeudaController::modificarPeriodo($solicitud->arriendo);
        } else {
            $solicitud->respuesta = false;
        }
        $solicitud->save();
        return $solicitud->arriendo->inmueble->id;
    }
    
}
