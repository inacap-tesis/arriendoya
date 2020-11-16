<?php

namespace App\Http\Controllers;

use App\Notifications\AnuncioNotificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\InteresAnuncio;
use App\Anuncio;
use App\Inmueble;

class InteresController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
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

        //Notificar a propietario
        $interes->anuncio->inmueble->propietario->notify(new AnuncioNotificacion($interes->anuncio, $interes->usuario, 1));

        return redirect('/anuncio/'.$request->id);
    }

    public function eliminar(Request $request) {
        if($request->id) {
            $interes = InteresAnuncio::where([['idAnuncio', '=', $request->id], ['rutUsuario', '=', Auth::user()->rut]])->first();
            $interes->delete();
            //Notificar a propietario
            $interes->anuncio->inmueble->propietario->notify(new AnuncioNotificacion($interes->anuncio, $interes->usuario, 2));
            return redirect('/anuncio/'.$request->id);
        } else {
            $interes = InteresAnuncio::where([['idAnuncio', '=', $request->anuncio], ['rutUsuario', '=', $request->usuario]])->first();
            $interes->delete();
            //Notificar a inquilino
            $interes->usuario->notify(new AnuncioNotificacion($interes->anuncio, Auth::user(), 3));
            return $interes;
        }
    }

    public function definirCandidatos(Request $request) {
        $anuncio = Anuncio::find($request->anuncio);
        $proceso = false;
        foreach($anuncio->intereses as $interes){
            $candidato = $interes->candidato;
            if($request[$interes->usuario->rut]) {
                $interes->candidato = true;
                $proceso = true;
            } else {
                $interes->candidato = false;
            }
            if($interes->modificar() && $candidato != $interes->candidato) {
                //Notificar a inquilino
                $interes->usuario->notify(new AnuncioNotificacion($interes->anuncio, Auth::user(), $interes->candidato ? 4 : 5));
            }
        }
        $inmueble = Inmueble::find($anuncio->idInmueble);
        $inmueble->idEstado = $proceso ? 4 : 2;
        $inmueble->save();
        return redirect('/inmuebles');
    }

}
