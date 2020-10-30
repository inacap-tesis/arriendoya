<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Arriendo;
use App\Inmueble;
use App\Anuncio;
use App\InteresAnuncio;

class ArriendoController extends Controller {

    public function formularioConfigurar($id) {
        $arriendo = Arriendo::where([['idInmueble', '=', $id], ['estado', '=', false]])->first();
        //$inmueble = Inmueble::find($id);
        $anuncio = Anuncio::find($id);
        $interes = InteresAnuncio::where([ ['idAnuncio', '=', $id], ['candidato', '=', true] ])->get();
        return view('arriendo.configurar', [
            //'inmueble' => $inmueble,
            'anuncio' => $anuncio,
            'intereses' => $interes,
            'arriendo' => $arriendo
        ]);
    }

    public function configurar(Request $request) {
        if($request->arriendo) {
            $arriendo = Arriendo::find($request->arriendo);
        } else {
            $arriendo = new Arriendo();
            $arriendo->idInmueble = $request->inmueble;
        }
        $arriendo->fechaInicio = $request->fechaInicio;
        $arriendo->fechaTerminoPropuesta = $request->fechaFin;
        $arriendo->canon = $request->canon;
        if($request->incluyeGarantia && $request->incluyeGarantia == 'true') {
            $arriendo->garantia = $request->garantia ? $request->garantia : null;
        } else { 
            $arriendo->garantia = null;
        }
        $arriendo->rutInquilino = $request->inquilino;
        $arriendo->diaPago = $request->diaPago;
        $arriendo->estado = false;
        $arriendo->subarriendo = $request->subarrendar && $request->subarrendar == 'true' ? true : false;
        if($request->modificarRenta && $request->modificarRenta == 'true') {
            $arriendo->mesesModificacionPeriodicidad = $request->periodicidad == 1 ? 12 : 6;
        } else { 
            $arriendo->mesesModificacionPeriodicidad = null;
        }
        $arriendo->urlContrato = null;
        $arriendo->numeroRenovacion = null;
        $arriendo->fechaTerminoReal = null;
        if($arriendo->save() && !$request->arriendo){
            $inmueble = Inmueble::find($request->inmueble);
            $inmueble->idEstado = 5;
            $inmueble->save();
        }
        return redirect('/inmueble/catalogo');
    }

    public function cancelar($id) {
        $arriendo = Arriendo::where('idInmueble', '=', $id)->latest('created_at')->first();
        if($arriendo) {
            $arriendo->delete();
            $inmueble = Inmueble::find($id);
            $inmueble->idEstado = 4;
            $inmueble->save();
        }
        return redirect('/inmueble/catalogo');
    }

}