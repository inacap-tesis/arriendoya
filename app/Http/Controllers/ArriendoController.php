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
use App\Calificacion;
use App\Http\Controllers\DeudaController;
use DateTime;

class ArriendoController extends Controller {


    public function __construct() {
        $this->middleware('auth');
    }

    public function listar() {
        $arriendos = Auth::user()->arriendos;
        return view('arriendo.listar', ['arriendos' => $arriendos]);
    }

    public function configurar($id) {
        $arriendo = Arriendo::where([['idInmueble', '=', $id], ['estado', '=', false]])->orderBy('fechaTerminoReal','DESC')->first();
        if($arriendo->calificacion) {
            $arriendo = null;
        }
        $interes = InteresAnuncio::where([ ['idAnuncio', '=', $id], ['candidato', '=', true] ])->get();
        return view('arriendo.configurar', [
            'anuncio' => $id,
            'intereses' => $interes,
            'arriendo' => $arriendo
        ]);
    }

    public function consultar($id) {
        $arriendo = Arriendo::find($id);
        $infoUsuario = Auth::user()->rut == $arriendo->inquilino->rut ? $arriendo->inmueble->propietario : $arriendo->inquilino;
        return view('arriendo.consultar', [
            'arriendo' => $arriendo,
            'usuario' => $infoUsuario
        ]);
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
        $arriendo->fechaTerminoReal = $request->fechaFin;
        if($arriendo->save()){
            $garantia = Garantia::find($arriendo->id);
            if($request->conGarantia) {
                $garantia = $garantia ? $garantia : new Garantia();
                $garantia->idArriendo = $arriendo->id;
                $garantia->estado = false;
                $garantia->diasRetraso = -1;
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
        return redirect('/inmuebles');
    }

    public function modificar(Request $request) {
        $arriendo = Arriendo::find($request->arriendo);
        $this->guardar($arriendo, $request);
        return redirect('/inmuebles');
    }

    public function eliminar(Request $request) {
        $arriendo = Arriendo::where('idInmueble', '=', $request->id)->orderBy('fechaTerminoReal','DESC')->first();
        $arriendo->inmueble->idEstado = 4;
        if($arriendo->inmueble->save()) {
            $arriendo->delete();
        }
        return redirect('/inmuebles');
    }

    public function cargarContrato($id) {
        $arriendo = Arriendo::where([['idInmueble', '=', $id], ['estado', '=', false]])->orderBy('fechaTerminoReal','DESC')->first();
        return view('arriendo.iniciar', [
            'arriendo' => $arriendo
        ]);
    }

    public function iniciar(Request $request) {
        $validator = \Validator::make($request->all(), [
            'documento' => 'file|mimes:pdf|max:1024',
        ]);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $arriendo = Arriendo::find($request->arriendo);
        if($arriendo) {
            $arriendo->estado = true;
            if($request['documento']) {
                $arriendo->urlContrato = $request->file('documento')->store('contratos');
            }
            //Cambia estado del arriendo
            if($arriendo->save()) {
                //Cambia estado de inmueble a arrendado
                $arriendo->inmueble->idEstado = 6;
                $arriendo->inmueble->save();

                //Deshabilita el anuncio
                $arriendo->inmueble->anuncio->interesados()->detach();
                $arriendo->inmueble->anuncio->estado = false;
                $arriendo->inmueble->anuncio->save();

                //Eliminar todos los antecedentes del inquilino
                foreach($arriendo->inquilino->antecedentes as $antecedente) {
                    \Storage::delete($antecedente->urlDocumento);
                    $antecedente->delete();
                }

                //Generar deudas al inquilino de acuerdo a las fechas establecidas
                DeudaController::generar($arriendo);
                
            }
        }
        return redirect('/inmuebles');
    }

    public function finalizarForzosamente(Request $request) {
        $arriendo = Arriendo::find($request->id);
        $arriendo->fechaTerminoReal = $arriendo->solicitudesFinalizacion->first()->fechaPropuesta;
        $arriendo->save();
        //Actualizar las deudas
        DeudaController::modificarPeriodo($arriendo);
        //Notificar a la contraparte
        return $arriendo->id;
    }

    public function descargarContrato($id) {
        $arriendo = Arriendo::find($id);
        $url = base_path().'/storage/app/public/'.$arriendo->urlContrato;
        $extension = pathinfo(storage_path($url), PATHINFO_EXTENSION);
        $headers = array('Content-Type: application/pdf');
        return \Response::download($url, 'Contrato.'.$extension, $headers);
    }

    public function obtenerContrato() {
        $url = base_path().'/storage/app/public/formato.docx';
        $extension = pathinfo(storage_path($url), PATHINFO_EXTENSION);
        //$headers = array('Content-Type: application/pdf');
        return \Response::download($url, 'Formato.'.$extension);
    }

    public static function finalizar($arriendo) {
        $arriendo->estado = false;
        $arriendo->save();
        $arriendo->inmueble->idEstado = 7;
        $arriendo->inmueble->save();
        $calificacion = new Calificacion();
        $calificacion->idArriendo = $arriendo->id;
        //Calcular nota al inquilino
        $conRetraso = $arriendo->deudas->where('diasRetraso', '>', 0)->count();
        $noPagos = $arriendo->deudas->where('diasRetraso', -1)->count();
        echo $arriendo->deudas->count().'-'.$conRetraso.'-'.$noPagos. PHP_EOL;
        $calificacion->cumplimientoInquilino = 0;
        $calificacion->save();
        //Enviar notificación a ambas partes
        echo 'Finalizó el arriendo '.$arriendo->id. PHP_EOL;
        return;
    }

    public function renovar() {
        
    }

    public static function preguntarRenovacion($arriendo) {
        if($arriendo->inquilino->notificaciones->where('idCategoria ', 15)->where('estado', true)->count() == 0) {
            //Enviar notificación a inquilino
        }
        if($arriendo->inmueble->propietario->notificaciones->where('idCategoria ', 15)->where('estado', true)->count() == 0) {
            //Enviar notificación a propietario
        }
    }

    public static function actualizar($arriendo, $fechaActual) {
        
        $fecha = new DateTime($arriendo->fechaTerminoReal);
        
        if($fecha < $fechaActual) {
            ArriendoController::finalizar($arriendo);
        } else {
            $intervalo = $fechaActual->diff($fecha);
            $diasDiferencia = (int)$intervalo->format('%R%a');
            
            //Consultar por renovación de arriendo cuando esté a 30, 15, 5, 2 y un día antes de finalizar.
            if($diasDiferencia == 30 || $diasDiferencia == 15 || $diasDiferencia == 5 || $diasDiferencia < 3) {
                ArriendoController::preguntarRenovacion($arriendo);
            }

            $deuda = $arriendo->deudas->where('estado', false)->first();
            if($deuda) {
                
                $fecha = new DateTime($deuda->fechaCompromiso);
                $intervalo = $fechaActual->diff($fecha);
                $diasDiferencia = (int)$intervalo->format('%R%a');
                
                //Recordar pago de renta a inquilinos cuando la fecha de compromiso esté a 5 días de cumplirse.
                if($diasDiferencia < 6) {
                    DeudaController::recordarPago($deuda);
                }

                //Informar morosidad a los inquilinos cuando la fecha de compromiso de pagos sea menor que la fecha actual.
                if($fecha < $fechaActual){
                    DeudaController::informarMorosidad($deuda);
                }
            }
        }
        return;
    }

}