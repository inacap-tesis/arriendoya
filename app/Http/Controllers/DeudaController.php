<?php

namespace App\Http\Controllers;

use App\Deuda;
use App\PagoDeuda;
use Illuminate\Http\Request;
use App\Http\Controllers\CatalogoController;
use Illuminate\Support\Str;
use DateTime;

class DeudaController extends Controller
{

    public function listar() {

    }

    public static function modificarPeriodo($arriendo) {
        $fin = new DateTime($arriendo->fechaTerminoPropuesta);
        $arriendo->deudas->where('fechaCompromiso', '>=', $arriendo->fechaTerminoPropuesta)->each->delete();
        $ultima = Deuda::where('idArriendo', $arriendo->id)->orderBy('fechaCompromiso', 'desc')->first();
        $fecha = new DateTime($ultima->fechaCompromiso);
        $periodoInicio = $fecha->format('d').' '.Str::substr(CatalogoController::consultarMes((int)$fecha->format('m')), 0, 3);
        $periodoFin = $fin->format('d').' '.Str::substr(CatalogoController::consultarMes((int)$fin->format('m')), 0, 3);
        $ultima->titulo = $periodoInicio.' - '.$periodoFin;;
        $ultima->save();
    }

    public static function generar($arriendo) {
        $pago = $arriendo->diaPago;
        $inicio = new DateTime($arriendo->fechaInicio);
        $fin = new DateTime($arriendo->fechaTerminoPropuesta);
        $fecha = new DateTime($arriendo->fechaInicio);
        $dia = (int)$fecha->format('d');
        $cant = 0;
        while($fecha < $fin) {
            if($fecha == $inicio) {
                if($dia < $pago) {
                    $mes = (int)$fecha->format('m');
                } else {
                    $mes = (int)$fecha->format('m') + 1;
                }
                $anio = (int)$fecha->format('Y');
            }
            $periodoInicio = $fecha->format('d').' '.Str::substr(CatalogoController::consultarMes((int)$fecha->format('m')), 0, 3);
            $periodoFin = ($pago - 1).' '.Str::substr(CatalogoController::consultarMes($mes), 0, 3);
            $deuda = new Deuda();
            $deuda->idArriendo = $arriendo->id;
            $deuda->fechaCompromiso = $fecha->format('Y-m-d');
            $deuda->estado = false;
            
            $dia = $pago;
            $fecha = new DateTime($anio.'-'.$mes.'-'.$dia);
            $mes++;
            if($mes > 12) {
                $anio++;
                $mes = 1;
            }
            if($fecha >= $fin) {
                $_mes = ((int)$fecha->format('d')) > ((int)$fin->format('d')) ? $mes - 1 : $mes - 2;
                $periodoFin = $fin->format('d').' '.Str::substr(CatalogoController::consultarMes($_mes), 0, 3);
            }
            $deuda->titulo = $periodoInicio.' - '.$periodoFin;
            if($deuda->save()) {
                $cant++;
            }
        }
        return $cant;
    }

    //Pertenece a PagoDeuda@registrar
    /*public function pagar(Request $request) {
        $deuda = Deuda::find($request->deuda);
        $deuda->estado = true;
        /*$actual = new \DateTime();
        $compromiso = new \DateTime($deuda->fechaCompromiso);
        $diferencia = $actual->diff($compromiso);
        $deuda->cantidadDiasRetraso = (($diferencia->y * 12) * 30) + ($diferencia->m * 30) + $diferencia->d;
        $deuda->fechaPago = $actual->format('Y-m-d');*/
        /*if($deuda->save()) {
            $pago = new PagoDeuda();
            $pago->idDeuda = $deuda->id;
            $actual = new \DateTime();
            $pago->fecha = $actual->format('Y-m-d');
            $pago->urlComprobante = $request->documento;
            $pago->save();
        }

        return redirect('/arriendo/consultar/'.$deuda->arriendo->id);
    }*/

}
