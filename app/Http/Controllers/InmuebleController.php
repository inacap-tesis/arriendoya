<?php

namespace App\Http\Controllers;

use App\Inmueble;
use App\Anuncio;
use App\Region;
use App\Provincia;
use App\Comuna;
use App\TipoInmueble;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InmuebleController extends Controller
{

    public function __construct() {
        //$this->middleware('auth', ['only' => ['misInmuebles']]);
        $this->middleware('auth');
    }

    public function misInmuebles() {
        $rut = Auth::user()->rut;
        return Inmueble::where('rutPropietario', $rut)->get();
    }

    public function listar() {
        $inmuebles = $this->misInmuebles();
        if(count($inmuebles) > 0) {
            return view('inmueble.catalogo', ['inmuebles'=> $inmuebles]);
        } else {
            return redirect('/inmueble/registrar');
        }
    }

    public function consultar($id = null) {
        $inmueble = $id ? Inmueble::find($id) : null;
        return view('inmueble.registrar', [
            'regiones' => Region::all(),
            'provincias' => Provincia::all(),
            'comunas' => Comuna::all(),
            'tipos_inmueble' => TipoInmueble::all(),
            'inmueble'=> $inmueble
            ]);
    }

    public function registrar(Request $request) {
        try {
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
            $inmueble->save();
            return view('inmueble.catalogo', ['inmuebles'=> $this->misInmuebles()]);
        } catch(Exception $error) {
            return $error;
        }
    }

    public function modificar(Request $request) {
        try {
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
            $inmueble->save();
            return view('inmueble.catalogo', ['inmuebles'=> $this->misInmuebles()]);
        } catch(Exception $error) {
            return $error;
        }
    }

    public function eliminar(Request $request) {
        try {
            $inmueble = Inmueble::find($request->id);
            return $inmueble;
            $inmueble->delete();
            return view('inmueble.catalogo', ['inmuebles'=> $this->misInmuebles()]);
        } catch(Exception $error) {
            return $error;
        }
    }

    public function activar(Request $request) {
        $inmueble = Inmueble::find($request->id);
        $inmueble->idEstado = 1;
        if($inmueble->save()) {
            return view('inmueble.catalogo', ['inmuebles'=> $this->misInmuebles()]);
        }
        return 'error';
    }

    public function desactivar(Request $request) {
        $inmueble = Inmueble::find($request->id);
        $inmueble->idEstado = 3;
        if($inmueble->save()) {
            return view('inmueble.catalogo', ['inmuebles'=> $this->misInmuebles()]);
        }
        return 'error';
    }
 
}
