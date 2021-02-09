<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Calificacion;
use App\Arriendo;
use App\Usuario;
use App\Notifications\CalificacionNotificacion;

class CalificacionController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function consultar($rut) {
        $usuario = Usuario::find($rut);
        $calificaciones = $usuario->calificacionesComoInquilino;
        foreach($calificaciones as $calificacio) {
            $propietario = $calificacio->arriendo->inmueble->propietario;
        }
        return $calificaciones;
    }

    public function configurar($id) {
        $arriendo = Arriendo::find($id);
        $usuario = $arriendo->inmueble->propietario;
        $propietario = false;
        if(Auth::user()->rut == $usuario->rut) {
            $usuario = $arriendo->inquilino;
            $propietario = true;
        }
        return view('calificacion.configurar', [
            'arriendo' => $arriendo,
            'usuario' => $usuario,
            'esPropietario' => $propietario
        ]);
    }

    public function calificar(Request $request) {
        $arriendo = Arriendo::find($request->arriendo);
        if($request->esPropietario == '1') {
            $arriendo->calificacion->notaAlInquilino = (int)$request->nota;
            $arriendo->calificacion->comentarioAlInquilino = $request->comentario;
            if(!$arriendo->garantia || $arriendo->garantia->devolucion) {
                $arriendo->inmueble->idEstado = 1;
                $arriendo->inmueble->save();
            }
            $arriendo->calificacion->save();
            //Notificar al inquilino
            $arriendo->inquilino->notify(new CalificacionNotificacion($arriendo->calificacion, $arriendo->inmueble->propietario, 1));
        } else {
            $arriendo->calificacion->notaAlArriendo = (int)$request->nota;
            $arriendo->calificacion->comentarioAlArriendo = $request->comentario;
            $arriendo->calificacion->save();
            //Notificar al propietario
            $arriendo->inmueble->propietario->notify(new CalificacionNotificacion($arriendo->calificacion, $arriendo->inquilino, 2));
        }

        return (int)$request->esPropietario;
    }

}
