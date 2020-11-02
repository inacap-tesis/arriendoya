<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Anuncio;
use App\FotoInmueble;
use App\InteresAnuncio;
use App\Inmueble;

class AnuncioController extends Controller {

    public function __construct(InmuebleController $_inmuebleController) {
        $this->middleware('auth', ['only' => ['mostrarInteres']]);
    }

    public function configurar($id) {
        $anuncio = Anuncio::find($id);
        $inmueble = Inmueble::find($id);
        return view('anuncio.publicar', [
            'anuncio' => $anuncio,
            'inmueble' => $inmueble
        ]);
    }

    public function consultar($id) {
        try {
            $anuncio = Anuncio::find($id);
            $fotos = $anuncio->inmueble->fotos;
            //$fotos = FotoInmueble::where('idInmueble', '=', $id)->get();
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
            $anuncio->inmueble->idEstado = 2;
            if($anuncio->inmueble->save()) {
                return view('inmueble.catalogo', [
                    'inmuebles'=> Inmueble::where('rutPropietario', Auth::user()->rut)->get()
                ]);
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
                return view('inmueble.catalogo', [
                    'inmuebles'=> Inmueble::where('rutPropietario', Auth::user()->rut)->get()
                ]);
            }
        }
        return 'error';
    }

    //Pertenere a InteresAnuncio@registrar
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

    //Pertenere a InteresAnuncio@eliminar
    public function quitarInteres($id) {
        try {
            $interes = InteresAnuncio::where([['idAnuncio', '=', $id], ['rutUsuario', '=', Auth::user()->rut]])->first();
            $interes->delete();
            return back();
        } catch (Exception $error) {
            return $error;
        }
    }

    //Pertenere a InteresAnuncio@listar
    public function verInteresados($id) {
        $anuncio = Anuncio::find($id);
        $intereses = InteresAnuncio::where('idAnuncio', '=', $anuncio->idInmueble)->get();
        return view('anuncio.interesados', [
            'anuncio' => $anuncio,
            'intereses' => $intereses
        ]);
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
        return redirect('/inmueble/catalogo');
    }

    public function eliminarInteresado($anuncio, $usuario) {
        $anuncio = Anuncio::find($anuncio);
        $anuncio->interesados()->detach($usuario);
        return back();
    }

}