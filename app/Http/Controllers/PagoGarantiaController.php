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
            'url' => '/garantia/pago',
            'id' => $id
            ]);
    }

    public function registrar(Request $request) {
        
        $garantia = Garantia::find($request->id);

        $pago = new PagoGarantia();
        $pago->idGarantia = $garantia->arriendo->id;
        $actual = new \DateTime();
        $pago->fecha = $actual->format('Y-m-d');
        $pago->urlComprobante = $request->file('documento')->store('pagosGarantia');
        $pago->save();

        $fechaCompromiso = new \DateTime($garantia->arriendo->fechaInicio);
        $fechaPago = new \DateTime($pago->fecha);
        $intervalo = $fechaCompromiso->diff($fechaPago);
        $dias = (int)$intervalo->format('%R%a');
        
        $garantia->diasRetraso = $dias > 0 ? $dias : 0;
        $garantia->estado = true;
        $garantia->save();

        return redirect('/arriendo/'.$garantia->arriendo->id);
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
        return $garantia->arriendo->id;
    }

}