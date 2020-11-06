<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Arriendo;
use App\Inmueble;
use App\Anuncio;
use App\InteresAnuncio;
use App\Deuda;
use App\Garantia;
use DateTime;

class ArriendoController extends Controller {

    public function listar() {
        $arriendos = Arriendo::where('rutInquilino', '=', Auth::user()->rut)->get();
        return view('arriendo.catalogo', ['arriendos' => $arriendos]);
    }

    public function configurar($id) {
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

    public function consultar($id) {
        $arriendo = Arriendo::find($id);
        return view('arriendo.consultar', ['arriendo' => $arriendo]);
    }

    private function guardar(Arriendo $arriendo, Request $request) {
        $arriendo->fechaInicio = $request->fechaInicio;
        $arriendo->fechaTerminoPropuesta = $request->fechaFin;
        $arriendo->canon = $request->canon;
        $arriendo->rutInquilino = $request->inquilino;
        $arriendo->diaPago = $request->diaPago;
        $arriendo->estado = false;
        $arriendo->urlContrato = null;
        $arriendo->numeroRenovacion = null;
        $arriendo->fechaTerminoReal = null;
        if($arriendo->save()){
            $garantia = Garantia::find($arriendo->id);
            if($request->conGarantia) {
                $garantia = $garantia ? $garantia : new Garantia();
                $garantia->idArriendo = $arriendo->id;
                $garantia->estado = false;
                $garantia->monto = $request->garantia;
                $garantia->save();
            } elseif($garantia) {
                $garantia->delete();
            }
            $inmueble = Inmueble::find($arriendo->idInmueble);
            $inmueble->idEstado = 5;
            $inmueble->save();
        }
    }

    public function registrar(Request $request) {
        $arriendo = new Arriendo();
        $arriendo->idInmueble = $request->inmueble;
        $this->guardar($arriendo, $request);
        return redirect('/inmueble/catalogo');
    }

    public function modificar(Request $request) {
        $arriendo = Arriendo::find($request->arriendo);
        $this->guardar($arriendo, $request);
        return redirect('/inmueble/catalogo');
    }

    public function eliminar($id) {
        $arriendo = Arriendo::where('idInmueble', '=', $id)->latest('created_at')->first();
        $arriendo->inmueble->idEstado = 4;
        if($arriendo->inmueble->save()) {
            $arriendo->delete();
        }
        return redirect('/inmueble/catalogo');
    }

    public function cargarContrato($id) {
        $arriendo = Arriendo::where([['idInmueble', '=', $id], ['estado', '=', false]])->first();
        return view('arriendo.iniciar', [
            'arriendo' => $arriendo
        ]);
    }

    private function mes($id) {
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
        if($arriendo) {
            $arriendo->estado = true;
            $arriendo->urlContrato = $request->documento ? $request->documento : '-';
            if($arriendo->save()) {
                //Cambia estado de inmueble a arrendado
                $arriendo->inmueble->idEstado = 6;
                $arriendo->inmueble->save();

                //Deshabilita el anuncio
                $arriendo->inmueble->anuncio->interesados()->detach();
                $arriendo->inmueble->anuncio->estado = false;
                $arriendo->inmueble->anuncio->save();

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
                    $deuda->titulo = $this->mes($mes).' - '.$anio;
                    $deuda->fechaCompromiso = $fecha->format('Y-m-d');
                    $deuda->estado = false;
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

    public function finalizar() {

    }

    public function finalizarForzosamente() {
        
    }

    public function renovar() {
        
    }

    public function preguntarRenovacion() {
        
    }

    public function descargarContrato() {
        
    }

    public function actualizar() {
        
    }

}