<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Anuncio;
use App\FotoInmueble;
use App\InteresAnuncio;
use App\Inmueble;

class AnuncioController extends Controller {

    public function __construct() {
        $this->middleware('auth', 
        ['only' => [
            'configurar',
            'activar',
            'desactivar'
        ]]);
    }

    public function configurar($inmueble) {
        $inmueble = Inmueble::find($inmueble);
        return view('anuncio.configurar', [ 'inmueble' => $inmueble ]);
    }

    public function consultar($id) {
        $anuncio = Anuncio::find($id);
        $interes = [];
        if(Auth::check()) {
            $interes = $anuncio->interesados->where('rut', '=', Auth::user()->rut);
        }
        return view('anuncio.consultar', [
            'anuncio' => $anuncio,
            'interes' => $interes
        ]);
    }

    public function activar(Request $request) {
        $anuncio = Anuncio::find($request->id);
        if(!$anuncio) {
            $anuncio = new Anuncio();
            $anuncio->idInmueble = $request->id;
        }
        $anuncio->condicionesArriendo = $request->condicionesArriendo;
        $anuncio->documentosRequeridos = $request->documentosRequeridos;
        $anuncio->canon = $request->canon;
        $anuncio->fechaPublicacion = Now();
        $anuncio->estado = true;
        if($anuncio->save()) {
            $inmueble = $anuncio->inmueble ? $anuncio->inmueble : Inmueble::find($request->id);
            $inmueble->idEstado = 2;
            if($inmueble->save()) {
                return redirect('/inmuebles');
            }
        }
        return 'error';
    }

    public function desactivar($id) {
        $anuncio = Anuncio::find($id);
        $anuncio->estado = false;
        if($anuncio->save()) {
            $anuncio->inmueble->idEstado = 1;
            if($anuncio->inmueble->save()) {
                return redirect('/inmuebles');
            }
        }
        return 'error';
    }

}