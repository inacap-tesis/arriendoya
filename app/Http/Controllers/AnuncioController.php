<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Anuncio;
use App\FotoInmueble;
use App\InteresAnuncio;

class AnuncioController extends Controller {

    public function __construct() {
        $this->middleware('auth', ['only' => ['mostrarInteres']]);
    }

    public function consultar($id) {
        try {
            $anuncio = Anuncio::find($id);
            $fotos = FotoInmueble::where('idInmueble', '=', $id)->get();
            $interes = [];
            if(Auth::check()) {
                $interes = InteresAnuncio::where([['idAnuncio', '=', $id], ['rutUsuario', '=', Auth::user()->rut]])->get();
            }
            return view('anuncio.consultar', [
                'anuncio' => $anuncio,
                'fotos' => $fotos,
                'interes' => $interes
            ]);
        } catch(Exception $error) {
            return $error;
        }
    }

    public function mostrarInteres($id) {
        try {
            $interes = new InteresAnuncio();
            $interes->idAnuncio = $id;
            $interes->rutUsuario = Auth::user()->rut;
            $interes->candidato = false;
            $interes->save();
            return back();
        } catch (Exception $error) {
            return $error;
        }
    }

    public function quitarInteres($id) {
        try {
            $interes = InteresAnuncio::where([['idAnuncio', '=', $id], ['rutUsuario', '=', Auth::user()->rut]])->first();
            $interes->delete();
            return back();
        } catch (Exception $error) {
            return $error;
        }
    }

    public function verInteresados($id) {
        $anuncio = Anuncio::find($id);
        return view('anuncio.interesados', [
            'anuncio' => $anuncio,
            'interesados' => $anuncio->interesados
        ]);
    }

    public function definirCandidatos(Request $request) {
        $anuncio = Anuncio::find($request->anuncio);
        foreach($anuncio->interesados as $interesado) {
            if($request[$interesado->rut]){
                return 'si';
            }
        }
        return 'no';
    }

}