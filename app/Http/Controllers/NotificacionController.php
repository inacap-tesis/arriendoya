<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function leida(Request $request) {
        $notificacion = Auth::user()->notifications->find($request->id);
        $notificacion->markAsRead();
        return $request;
    }

    public function eliminar(Request $request) {
        $notificacion = Auth::user()->notifications->find($request->id);
        $notificacion->delete();
        return $request;
    }

    /*public function registrar($usuario, $tipo, $ref, $mensaje) {
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
        
    }*/

}
