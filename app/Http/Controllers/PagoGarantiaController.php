<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PagoGarantia;
use App\Garantia;

class PagoGarantiaController extends Controller
{
    
    public function listar() {

    }

    public function consultar($id) {
        $garantia = Garantia::find($id);
        return view('deuda.pagar', ['deuda' => $garantia]);
    }

    public function registrar(Request $request) {
        $garantia = Garantia::find($request->id);
        $garantia->estado = true;
        if($garantia->save()) {
            $pago = new PagoDeuda();
            $pago->idDeuda = $deuda->id;
            $actual = new \DateTime();
            $pago->fecha = $actual->format('Y-m-d');
            $pago->urlComprobante = $request->documento;
            $pago->save();
        }

        return redirect('/arriendo/consultar/'.$deuda->arriendo->id);
    }

    public function descargarComprobante($id) {
        
    }

}