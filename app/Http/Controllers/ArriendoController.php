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
use App\Http\Controllers\DeudaController;

class ArriendoController extends Controller {


    public function __construct() {
        $this->middleware('auth');
    }

    public function listar() {
        $arriendos = Arriendo::where('rutInquilino', '=', Auth::user()->rut)->get();
        return view('arriendo.listar', ['arriendos' => $arriendos]);
    }

    public function configurar($id) {
        $arriendo = Arriendo::where([['idInmueble', '=', $id], ['estado', '=', false]])->first();
        $interes = InteresAnuncio::where([ ['idAnuncio', '=', $id], ['candidato', '=', true] ])->get();
        return view('arriendo.configurar', [
            'anuncio' => $id,
            'intereses' => $interes,
            'arriendo' => $arriendo
        ]);
    }

    public function consultar($id) {
        $arriendo = Arriendo::find($id);
        if($arriendo == null) {
            $arriendo = Inmueble::find($id)->arriendos->where('estado', '=', true)->first();
            $infoUsuario = $arriendo->inquilino;
        } else {
            $infoUsuario = $arriendo->inmueble->propietario;
        }
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
        return redirect('/inmuebles');
    }

    public function modificar(Request $request) {
        $arriendo = Arriendo::find($request->arriendo);
        $this->guardar($arriendo, $request);
        return redirect('/inmuebles');
    }

    public function eliminar(Request $request) {
        $arriendo = Arriendo::where('idInmueble', '=', $request->id)->latest('created_at')->first();
        $arriendo->inmueble->idEstado = 4;
        if($arriendo->inmueble->save()) {
            $arriendo->delete();
        }
        return redirect('/inmuebles');
    }

    public function cargarContrato($id) {
        $arriendo = Arriendo::where([['idInmueble', '=', $id], ['estado', '=', false]])->first();
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

    public function finalizar() {

    }

    public function finalizarForzosamente() {
        
    }

    public function renovar() {
        
    }

    public function preguntarRenovacion() {
        
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

    public function actualizar() {
        
    }

}