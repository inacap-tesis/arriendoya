<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PagoGarantia;
use App\Garantia;

class PagoGarantiaController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function configurar($id) {
        $garantia = Garantia::find($id);
        return view('pago.configurar', [
            'deuda' => $garantia,
            'monto' =>$garantia->monto,
            'tipo' => 'garantia',
            'id' => $id
            ]);
    }

    public function registrar(Request $request) {
        $garantia = Garantia::find($request->id);
        $garantia->estado = true;
        if($garantia->save()) {
            $pago = new PagoGarantia();
            $pago->idGarantia = $garantia->arriendo->id;
            $actual = new \DateTime();
            $pago->fecha = $actual->format('Y-m-d');
            $pago->urlComprobante = $request->file('documento')->store('pagosGarantia');
            $pago->save();
        }

        return redirect('/arriendo/'.$garantia->arriendo->inmueble->id);
    }

    public function descargarComprobante($id) {
        $pago = PagoGarantia::find($id);
        $url = base_path().'/storage/app/public/'.$pago->urlComprobante;
        $extension = pathinfo(storage_path($url), PATHINFO_EXTENSION);
        return \Response::download($url, 'comprobante.'.$extension);
    }

    public function reportarProblema(Request $request) {
        $garantia = Garantia::find($request->id);
        $garantia->estado = false;
        $garantia->save();
        return $garantia->arriendo->inmueble->id;
    }

}