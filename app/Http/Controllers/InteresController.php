<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\InteresAnuncio;
use App\Anuncio;
use App\Inmueble;

class InteresController extends Controller
{

    private $notificacionController = null;

    public function __construct() {
        $this->middleware('auth');
        $this->notificacionController = new NotificacionController();
    }

    public function listar($anuncio) {
        $intereses = InteresAnuncio::where('idAnuncio', '=', $anuncio)->get();
        return view('interes.listar', [
            'anuncio' => $anuncio,
            'intereses' => $intereses
        ]);
    }

    public function registrar(Request $request) {
        $interes = new InteresAnuncio();
        $interes->idAnuncio = $request->id;
        $interes->rutUsuario = Auth::user()->rut;
        $interes->candidato = false;
        $interes->save();

        //Generar notificación a propietario de tipo 1

        return redirect('/anuncio/'.$request->id);
    }

    /*
    public function eliminarInteresado($anuncio, $usuario) {
        $anuncio = Anuncio::find($anuncio);
        $anuncio->interesados()->detach($usuario);
        return back();
    }
    */

    public function eliminar(Request $request) {
        if($request->id) {
            $interes = InteresAnuncio::where([['idAnuncio', '=', $request->id], ['rutUsuario', '=', Auth::user()->rut]])->first();
            $interes->delete();
            return redirect('/anuncio/'.$request->id);
        } else {
            $interes = InteresAnuncio::where([['idAnuncio', '=', $request->anuncio], ['rutUsuario', '=', $request->usuario]])->first();
            $interes->delete();
            return $interes;
        }
    }

    public function definirCandidatos(Request $request) {
        $anuncio = Anuncio::find($request->anuncio);
        $interesados = $anuncio->interesados;
        $anuncio->interesados()->detach();
        $proceso = false;
        foreach($interesados as $interesado) {
            $interes = new InteresAnuncio();
            $interes->idAnuncio = $anuncio->idInmueble;
            $interes->rutUsuario = $interesado->rut;
            if($request[$interesado->rut]) {
                $interes->candidato = true;
                $proceso = true;
            } else {
                $interes->candidato = false;
            }
            $interes->save();
        }
        $inmueble = Inmueble::find($anuncio->idInmueble);
        $inmueble->idEstado = $proceso ? 4 : 2;
        $inmueble->save();
        return redirect('/inmuebles');
    }

}
