<?php

namespace App\Http\Controllers;

use App\Notificacion;
use App\Deuda;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    
    public function listar() {
        
    }

    public function registrar($usuario, $tipo, $ref, $mensaje) {
        $notificacion = new Notificacion();
        $notificacion->rutUsuario = $usuario;
        $notificacion->idCategoria = $tipo;
        $notificacion->idReferencia = $ref;
        $notificacion->mensaje = $mensaje;
        $notificacion->estado = true;
        return $notificacion->save();
    }

    public function eliminar() {
        
    }

    public function registrarProblemaDeuda(Request $request) {
        $deuda = Deuda::find($request->id);
        $deuda->estado = false;
        //$deuda->save();
        $notificacion = new Notificacion();
        $notificacion->rutUsuario = $request->rut;
        $notificacion->idCategoria = $request->tipo;
        $notificacion->idReferencia = $request->id;
        $notificacion->mensaje = $request->mensaje;
        $notificacion->estado = true;
        dd($notificacion);
    }

    public function solucionarProblemaDeuda() {
        
    }

    public function registrarProblemaGarantia() {
        
    }

    public function solucionarProblemaGarantia() {
        
    }

    public function registrarSolicitudFinalizacion() {
        
    }

    public function responderSolicitudFinalizacion() {
        
    }

    public function reportarProblemaGarantia() {
        
    }

    public function reportarProblemaPago() {
        
    }

}
