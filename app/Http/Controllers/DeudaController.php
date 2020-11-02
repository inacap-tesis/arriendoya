<?php

namespace App\Http\Controllers;

use App\Deuda;
use App\PagoDeuda;
use Illuminate\Http\Request;

class DeudaController extends Controller
{
    
    //Pertenece a PagoDeuda@consultar
    public function formularioPagar($id) {
        $deuda = Deuda::find($id);
        return view('deuda.pagar', ['deuda' => $deuda]);
    }

    //Pertenece a PagoDeuda@registrar
    public function pagar(Request $request) {
        $deuda = Deuda::find($request->deuda);
        $actual = new \DateTime();
        $compromiso = new \DateTime($deuda->fechaCompromiso);
        $diferencia = $actual->diff($compromiso);
        $deuda->cantidadDiasRetraso = (($diferencia->y * 12) * 30) + ($diferencia->m * 30) + $diferencia->d;
        $deuda->fechaPago = $actual->format('Y-m-d');
        if($deuda->save()) {
            $pago = new PagoDeuda();
            $pago->idDeuda = $deuda->id;
            $pago->fecha = $actual->format('Y-m-d');
            $pago->urlComprobante = $request->documento;
            $pago->save();
        }

        return redirect('/arriendo/consultar/'.$deuda->arriendo->id);
    }

    //Pertenece a PagoDeuda@descargarComprobante
    public function descargarComprobante($id) {
        return 'Pendiente acción de descargar comprobante.';
    }

}
