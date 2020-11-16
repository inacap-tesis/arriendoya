<?php

namespace App\Http\Controllers;

use App\Notifications\AnuncioNotificacion;
use App\Notifications\ArriendoNotificacion;
use App\Notifications\CalificacionNotificacion;
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
use App\Http\Requests\ArriendoRequest;
use DateTime;

class ArriendoController extends Controller {


    public function __construct() {
        $this->middleware('auth');
    }

    public function listar() {
        $arriendos = [];
        foreach(Auth::user()->arriendos->groupBy('idInmueble') as $lista) {
            array_push($arriendos, $lista->sortByDesc('id')->first());
        }
        return view('arriendo.listar', ['arriendos' => $arriendos]);
    }

    public function configurar($id) {
        if(Auth::user()->cuentaBancaria) {
            $fechaActual = new \DateTime();
            $arriendo = Arriendo::where('idInmueble', $id)
                ->where('estado', false)
                ->where('fechaTerminoReal', '>', $fechaActual->format('Y-m-d'))
                ->orderBy('fechaTerminoReal', 'desc')->first();
            $interes = InteresAnuncio::where([ ['idAnuncio', '=', $id], ['candidato', '=', true] ])->get();
            return view('arriendo.configurar', [
                'anuncio' => $id,
                'intereses' => $interes,
                'arriendo' => $arriendo
            ]);
        } else {
            return redirect('/cuenta')->with('msg', 'Por favor primero configure su cuenta bancaria');
        }
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
        $arriendo->renovar = true;
        $arriendo->urlContrato = null;
        $arriendo->numeroRenovacion = 0;
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
        $validator = \Validator::make($request->all(), [
            'fechaInicio' => 'required',
            'fechaFin' => 'required',
            'canon' => 'required|min:0',
            'diaPago' => 'required|min:0|max:28'
        ], [
            'fechaInicio.required' => 'fecha requerida'
        ]);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $arriendo = new Arriendo();
        $arriendo->idInmueble = $request->inmueble;
        $this->guardar($arriendo, $request);
        return redirect('/inmuebles')->with('msg', 'Arriendo configurado');
    }

    public function modificar(Request $request) {
        $arriendo = Arriendo::find($request->arriendo);
        $this->guardar($arriendo, $request);
        return redirect('/inmuebles')->with('msg', 'Arriendo modificado');
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

                //Notificar al inquilino
                $arriendo->inquilino->notify(new ArriendoNotificacion($arriendo, $arriendo->inmueble->propietario, 1));
                //Notificar al propietario
                $arriendo->inmueble->propietario->notify(new ArriendoNotificacion($arriendo, $arriendo->inquilino, 1));

                //Cambia estado de inmueble a arrendado
                $arriendo->inmueble->idEstado = 6;
                $arriendo->inmueble->save();

                //Deshabilita el anuncio
                $propietario = $arriendo->inmueble->propietario;
                $interesInquilino = $arriendo->inmueble->anuncio->intereses->where('rutUsuario', $arriendo->inquilino->rut)->first();
                $arriendo->inmueble->anuncio->intereses->each(function (InteresAnuncio $interes) use ($propietario, $interesInquilino) {
                    //Notificar a todos los interesados, la baja del anuncio.
                    if($interes->usuario->rut != $interesInquilino->usuario->rut) {
                        $interes->usuario->notify(new AnuncioNotificacion($interes->anuncio, $propietario, 6));
                        $interes->delete();
                    }
                });
                $interesInquilino->delete();
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

    public function rechazarRenovacion(Request $request) {
        $arriendo = Arriendo::find($request->id);
        $arriendo->renovar = false;
        return $arriendo->save();
    }

    public static function renovar($arriendo) {
    
        $fechaInicio = new \DateTime($arriendo->fechaInicio);
        $fechaTermino = new \DateTime($arriendo->fechaTerminoPropuesta);

        $intervalo = $fechaInicio->diff($fechaTermino);
        
        $fechaActual = new \DateTime();
        $nuevoFin = new \DateTime();
        $nuevoFin->add($intervalo);

        $nuevo = new Arriendo();
        $nuevo->idInmueble = $arriendo->inmueble->id;
        $nuevo->fechaInicio = $fechaActual->format('Y-m-d');
        $nuevo->fechaTerminoPropuesta = $nuevoFin->format('Y-m-d');
        $nuevo->fechaTerminoReal = $nuevoFin->format('Y-m-d');
        $nuevo->canon = $arriendo->canon;
        $nuevo->rutInquilino = $arriendo->inquilino->rut;
        $nuevo->diaPago = $arriendo->diaPago;
        $nuevo->estado = true;
        $nuevo->renovar = $arriendo->renovar;
        $nuevo->urlContrato = null; //Despues podrá cargar uno
        $nuevo->numeroRenovacion = $arriendo->numeroRenovacion + 1;
        
        $nuevo->save();
        /*if( && $arriendo->garantia){
            $arriendo->garantia->idArriendo = $nuevo->id;
            $arriendo->garantia->save();
        }*/
        $nuevo->inmueble->idEstado = 6;
        $nuevo->inmueble->save();

        //Generar deudas al inquilino de acuerdo a las fechas establecidas
        DeudaController::generar($nuevo);

        //Notificar al inquilino
        $arriendo->inquilino->notify(new ArriendoNotificacion($arriendo, $arriendo->inmueble->propietario, 5));
        //Notificar al propietario
        $arriendo->inmueble->propietario->notify(new ArriendoNotificacion($arriendo, $arriendo->inquilino, 5));

        echo 'Arriendo '.$arriendo->id.' renovado'. PHP_EOL;
        return;
    }

    public static function finalizar($arriendo) {
        $arriendo->estado = false;
        $arriendo->save();
        $arriendo->inmueble->idEstado = 7;
        $arriendo->inmueble->save();
        
        if(!$arriendo->renovar) {
            $calificacion = new Calificacion();
            $calificacion->idArriendo = $arriendo->id;
            //Calcular nota al inquilino
            $conRetraso = $arriendo->deudas->where('diasRetraso', '>', 0)->count();
            $noPagos = $arriendo->deudas->where('diasRetraso', -1)->count();
            $periodos = $arriendo->deudas->count();
            $nota = (($periodos - $conRetraso - ($noPagos * 1.5)) / $periodos) * 5;
            $calificacion->cumplimientoInquilino = $nota < 0 ? 1 : $nota;
            $calificacion->save();
            
            //Notificar al inquilino
            $arriendo->inquilino->notify(new ArriendoNotificacion($arriendo, $arriendo->inmueble->propietario, 3));
            $arriendo->inquilino->notify(new CalificacionNotificacion($arriendo->calificacion, $arriendo->inmueble->propietario, 3));
            //Notificar al propietario
            $arriendo->inmueble->propietario->notify(new ArriendoNotificacion($arriendo, $arriendo->inquilino, 3));
        }
        
        echo 'Arriendo '.$arriendo->id.' finalizado'. PHP_EOL;
        return;
    }

    public static function preguntarRenovacion($arriendo) {
        //Notificar al inquilino
        $arriendo->inquilino->notify(new ArriendoNotificacion($arriendo, $arriendo->inmueble->propietario, 2));
        //Notificar al propietario
        $arriendo->inmueble->propietario->notify(new ArriendoNotificacion($arriendo, $arriendo->inquilino, 2));
    }

    public static function actualizar($arriendo, $fechaActual) {
        
        $fecha = new DateTime($arriendo->fechaTerminoReal);
        
        if($fecha < $fechaActual) {
            ArriendoController::finalizar($arriendo);
            if($arriendo->renovar) {
                ArriendoController::renovar($arriendo);
            }
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