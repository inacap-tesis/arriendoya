<?php

namespace App\Http\Controllers;

use App\Inmueble;
use App\Anuncio;
use App\Region;
use App\Provincia;
use App\Comuna;
use App\TipoInmueble;
use App\FotoInmueble;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CatalogoController;

class InmuebleController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function listar() {
        $inmuebles = Auth::user()->inmuebles;
        return view('inmueble.listar', ['inmuebles'=> $inmuebles]);
    }

    public function configurar($id = null) {
        if($id) {
            $inmueble = Inmueble::find($id);
            $provincias = CatalogoController::consultarProvincias()->where('idRegion', '=', $inmueble->comuna->provincia->idRegion);
            $comunas = CatalogoController::consultarComunas()->where('idProvincia', '=', $inmueble->comuna->idProvincia);
        } else {
            $inmueble = null;
            $provincias = null;
            $comunas = null;
        }
        return view('inmueble.configurar', [
            'regiones' => CatalogoController::consultarRegiones(),
            'provincias' => $provincias,
            'comunas' => $comunas,
            'tipos_inmueble' => TipoInmueble::all(),
            'inmueble'=> $inmueble
            ]);
    }

    public function registrar(Request $request) {
        $validator = \Validator::make($request->all(), [
            'foto1' => 'file|mimes:jpeg,jpg,png',
            'foto2' => 'file|mimes:jpeg,jpg,png',
            'foto3' => 'file|mimes:jpeg,jpg,png',
            'foto4' => 'file|mimes:jpeg,jpg,png',
            'foto5' => 'file|mimes:jpeg,jpg,png'
        ]);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $inmueble = new Inmueble();
        $inmueble->idTipoInmueble = $request->tipo;
        $inmueble->idEstado = 1;
        $inmueble->idComuna = $request->comuna;
        $inmueble->rutPropietario = Auth::user()->rut;
        $inmueble->poblacionDireccion = $request->poblacionDireccion;
        $inmueble->calleDireccion = $request->calleDireccion;
        $inmueble->numeroDireccion = $request->numeroDireccion;
        $inmueble->condominioDireccion = $request->condominioDireccion;
        $inmueble->numeroDepartamentoDireccion = $request->numeroDepartamentoDireccion;
        $inmueble->caracteristicas = $request->caracteristicas;
        if($inmueble->save()) {
            for($i=1;$i<=5;$i++) {
                if($request['foto'.$i]) {
                    $foto = new FotoInmueble();
                    $foto->idInmueble = $inmueble->id;
                    $foto->urlFoto = $request->file('foto'.$i)->store('inmuebles');
                    $foto->save();
                }
            }
        }
        return redirect('/inmuebles');
    }

    public function modificar(Request $request) {
        $validator = \Validator::make($request->all(), [
            'foto1' => 'file|mimes:jpeg,jpg,png',
            'foto2' => 'file|mimes:jpeg,jpg,png',
            'foto3' => 'file|mimes:jpeg,jpg,png',
            'foto4' => 'file|mimes:jpeg,jpg,png',
            'foto5' => 'file|mimes:jpeg,jpg,png'
        ]);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $inmueble = Inmueble::find($request->id);
        $inmueble->idTipoInmueble = $request->tipo;
        $inmueble->idComuna = $request->comuna;
        $inmueble->rutPropietario = Auth::user()->rut;
        $inmueble->poblacionDireccion = $request->poblacionDireccion;
        $inmueble->calleDireccion = $request->calleDireccion;
        $inmueble->numeroDireccion = $request->numeroDireccion;
        $inmueble->condominioDireccion = $request->condominioDireccion;
        $inmueble->numeroDepartamentoDireccion = $request->numeroDepartamentoDireccion;
        $inmueble->caracteristicas = $request->caracteristicas;
        if($inmueble->save()) {
            for($i=1;$i<=5;$i++) {
                if($request['_'.$i] && $request['_'.$i] == 1) {
                    $position = $i - 1;
                    $foto = $inmueble->fotos->slice($position, 1)->first();
                    \Storage::delete($foto->urlFoto);
                    if($request['foto'.$i]) {
                        $foto->urlFoto = $request->file('foto'.$i)->store('inmuebles');
                        $foto->save();
                    } else {
                        $foto->delete();
                    }
                } elseif($request['foto'.$i]) {
                    $foto = new FotoInmueble();
                    $foto->idInmueble = $inmueble->id;
                    $foto->urlFoto = $request->file('foto'.$i)->store('inmuebles');
                    $foto->save();
                }
            }   
        }
        return redirect('/inmuebles');
    }

    public function eliminar(Request $request) {
        $inmueble = Inmueble::find($request->id);
        $inmueble->delete();
        return redirect('/inmuebles');
    }

    public function activar(Request $request) {
        $inmueble = Inmueble::find($request->id);
        $inmueble->idEstado = 1;
        $inmueble->save();
        return redirect('/inmuebles');
    }

    public function desactivar(Request $request) {
        $inmueble = Inmueble::find($request->id);
        $inmueble->idEstado = 3;
        $inmueble->save();
        return redirect('/inmuebles');
    }
 
}
