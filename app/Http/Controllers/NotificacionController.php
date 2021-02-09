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

}
