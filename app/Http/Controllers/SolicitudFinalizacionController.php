<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\SolicitudFinalizacion;
use App\Arriendo;
use App\Http\Controllers\NotificacionController;

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

        return $request->id;
    }

    public function responder(Request $request) {
        $solicitud = SolicitudFinalizacion::find($request->id);
        $solicitud->respuesta = $request->respuesta == 'true';
        $solicitud->save();
        return $solicitud->idArriendo;
    }
    
}
