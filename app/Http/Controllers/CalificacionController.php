<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Calificacion;
use App\Arriendo;
use App\Usuario;

class CalificacionController extends Controller
{

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
        } else {
            $arriendo->calificacion->notaAlArriendo = (int)$request->nota;
            $arriendo->calificacion->comentarioAlArriendo = $request->comentario;
        }
        $arriendo->calificacion->save();
        return (int)$request->esPropietario;
    }

    public function calificarInmueblePropietario() {

    }

    public function calificarInquilino() {
        
    }

    public function registrarCalificacionInmueblePropietario() {
        
    }

    public function registrarCalificacionInquilino() {
        
    }

    public function consultarCalificacionesInmueble() {
        
    }

    public function consultarCalificacionesInquilino() {
        
    }

    public function consultarCalificacionesPropietario() {
        
    }
    
}
