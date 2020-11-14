<?php

namespace App\Http\Controllers;

use App\Deuda;
use App\Arriendo;
use App\PagoDeuda;
use Illuminate\Http\Request;
use App\Http\Controllers\CatalogoController;
use Illuminate\Support\Str;
use DateTime;

class DeudaController extends Controller
{

    public function listar() {

    }

    public static function modificarPeriodo(Arriendo $arriendo) {
        $fin = new DateTime($arriendo->fechaTerminoReal);
        $arriendo->deudas->where('fechaCompromiso', '>=', $arriendo->fechaTerminoReal)->each->delete();
        $ultima = Deuda::where('idArriendo', $arriendo->id)->orderBy('fechaCompromiso', 'desc')->first();
        $fecha = new DateTime($ultima->fechaCompromiso);
        $periodoInicio = $fecha->format('d').' '.Str::substr(CatalogoController::consultarMes((int)$fecha->format('m')), 0, 3);
        $periodoFin = $fin->format('d').' '.Str::substr(CatalogoController::consultarMes((int)$fin->format('m')), 0, 3);
        $ultima->titulo = $periodoInicio.' - '.$periodoFin;;
        $ultima->save();
    }

    public static function fechaFin($fechaInicio, $diaPago) {

        $dia = (int)$fechaInicio->format('d');
        $mes = (int)$fechaInicio->format('m');
        $anio = (int)$fechaInicio->format('Y');

        if($dia < $diaPago) {
            $diaPago--;
            return new DateTime($anio.'-'.$mes.'-'.$diaPago);
        } else {
            if($dia == 1 || $diaPago == 1) {
                $fechaFin = new DateTime($fechaInicio->format('Y-m-t'));
                $diaFin = (int)$fechaFin->format('d');
                return new DateTime($anio.'-'.$mes.'-'.$diaFin);
            } else {
                $mes++;
                if($mes > 12) {
                    $mes = 1;
                    $anio++;
                }
                $dia--;
                if($dia > $diaPago) {
                    $dia = $diaPago - 1;
                }
                return new DateTime($anio.'-'.$mes.'-'.$dia);
            }
        }
    }

    public static function generar($arriendo) {
        $pago = $arriendo->diaPago;
        $inicio = new DateTime($arriendo->fechaInicio);
        $fin = new DateTime($arriendo->fechaTerminoReal);
        
        $fecha = new DateTime($arriendo->fechaInicio);
        $periodoInicio = $fecha->format('d').' '.Str::substr(CatalogoController::consultarMes((int)$fecha->format('m')), 0, 3);
        $fechaFin = DeudaController::fechaFin($fecha, $pago);
        $periodoFin = $fechaFin->format('d').' '.Str::substr(CatalogoController::consultarMes((int)$fechaFin->format('m')), 0, 3);

        //Se guarda el primer periodo
        $deuda = new Deuda();
        $deuda->idArriendo = $arriendo->id;
        $deuda->fechaCompromiso = $fecha->format('Y-m-d');
        $deuda->estado = false;
        $deuda->titulo = $periodoInicio.' - '.$periodoFin;
        $deuda->save();

        $cant = 1;
        $mes = (int)$fecha->format('m');
        $anio = (int)$fecha->format('Y');
        do {

            $mes++;
            if($mes > 12) {
                $anio++;
                $mes = 1;
            }
            $fecha = new DateTime($anio.'-'.$mes.'-'.$pago);
            $periodoInicio = $fecha->format('d').' '.Str::substr(CatalogoController::consultarMes($mes), 0, 3);

            $fechaFin = DeudaController::fechaFin($fecha, $pago);
            if($fechaFin > $fin) {
                $periodoFin = $fin->format('d').' '.Str::substr(CatalogoController::consultarMes((int)$fin->format('m')), 0, 3);
            } else {
                $periodoFin = $fechaFin->format('d').' '.Str::substr(CatalogoController::consultarMes((int)$fechaFin->format('m')), 0, 3);
                //$periodoFin = DeudaController::periodoFin($fecha, $pago);
            }

            $deuda = new Deuda();
            $deuda->idArriendo = $arriendo->id;
            $deuda->fechaCompromiso = $fecha->format('Y-m-d');
            $deuda->estado = false;
            $deuda->titulo = $periodoInicio.' - '.$periodoFin;
            $deuda->save();
            $cant++;
        } while ($fechaFin < $fin);

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
