<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Arriendo;
use App\Inmueble;
use App\Anuncio;
use App\InteresAnuncio;
use App\Deuda;
use DateTime;

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
        if($arriendo->save()){
            $inmueble = Inmueble::find($arriendo->idInmueble);
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

    public function formularioIniciar($id) {
        $arriendo = Arriendo::where([['idInmueble', '=', $id], ['estado', '=', false]])->first();
        return view('arriendo.iniciar', [
            'arriendo' => $arriendo
        ]);
    }

    private function Mes($id) {
        switch ($id) {
            case 1: return 'ENERO';
            case 2: return 'FEBRERO';
            case 3: return 'MARZO';
            case 4: return 'ABRIL';
            case 5: return 'MAYO';
            case 6: return 'JUNIO';
            case 7: return 'JULIO';
            case 8: return 'AGOSTO';
            case 9: return 'SEPTIEMBRE';
            case 10: return 'OCTUBRE';
            case 11: return 'NOVIEMBRE';
            case 12: return 'DICIEMBRE';
            default: return '';
        }
    }

    public function iniciar(Request $request) {
        $arriendo = Arriendo::find($request->arriendo);
        //$arriendo = Arriendo::where([['idInmueble', '=', $request->arriendo], ['estado', '=', false]])->first();
        if($arriendo) {
            $arriendo->estado = true;
            $arriendo->urlContrato = $request->documento ? $request->documento : '-';
            if($arriendo->save()) {
                //Cambia estado de inmueble a arrendado
                $inmueble = Inmueble::find($arriendo->idInmueble);
                $inmueble->idEstado = 6;
                $inmueble->save();

                //Deshabilita el anuncio
                $anuncio = Anuncio::find($arriendo->idInmueble);
                $anuncio->interesados()->detach();
                $anuncio->estado = false;
                $anuncio->save();

                //Eliminar todos los antecedentes del inquilino

                //Generar deudas al inquilino de acuerdo a las fechas establecidas
                $pago = $arriendo->diaPago;
                $inicio = new DateTime($arriendo->fechaInicio);
                $fin = new DateTime($arriendo->fechaTerminoPropuesta);

                $fecha = new DateTime($arriendo->fechaInicio);
                $dia = (int)$fecha->format('d');
                while($fecha < $fin) {
                    if($fecha == $inicio) {
                        if($dia < $pago) {
                            $mes = (int)$fecha->format('m');
                        } else {
                            $mes = (int)$fecha->format('m') + 1;
                        }
                        $anio = (int)$fecha->format('Y');
                    }
                    $deuda = new Deuda();
                    $deuda->idArriendo = $arriendo->id;
                    $deuda->tipo = 'canon';
                    $deuda->fechaCompromiso = $fecha->format('Y-m-d');
                    $deuda->titulo = $this->Mes($mes).' - '.$anio;
                    $deuda->save();
                    $dia = $pago;
                    $fecha = new DateTime($anio.'-'.$mes.'-'.$dia);
                    $mes++;
                    if($mes > 12) {
                        $anio++;
                        $mes = 1;
                    }
                }
                
            }
        }
        return redirect('/inmueble/catalogo');
    }

    public function catalogo() {
        $arriendos = Arriendo::where('rutInquilino', '=', Auth::user()->rut)->get();
        return view('arriendo.catalogo', ['arriendos' => $arriendos]);
    }

    public function consultar($id) {
        $arriendo = Arriendo::find($id);
        return view('arriendo.consultar', ['arriendo' => $arriendo]);
    }

}