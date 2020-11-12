<?php

namespace App\Http\Controllers;

use App\Deuda;
use App\PagoDeuda;
use Illuminate\Http\Request;

class DeudaController extends Controller
{

    public function listar() {

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
