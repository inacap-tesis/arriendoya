<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Deuda;
use App\PagoDeuda;
use App\Notificacion;
use App\Http\Controllers\CatalogoController;

class PagoDeudaController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function configurar($id) {
        $deuda = Deuda::find($id);
        return view('pago.configurar', [
            'deuda' => $deuda,
            'monto' =>$deuda->arriendo->canon,
            'url' => '/deuda/pago',
            'id' => $deuda->id
            ]);
    }

    public function registrar(Request $request) {
        
        $deuda = Deuda::find($request->id);

        $pago = new PagoDeuda();
        $pago->idDeuda = $deuda->id;
        $actual = new \DateTime();
        $pago->fecha = $actual->format('Y-m-d');
        $pago->urlComprobante = $request->file('documento')->store('pagosDeuda');
        $pago->save();

        $fechaCompromiso = new \DateTime($deuda->fechaCompromiso);
        $fechaPago = new \DateTime($pago->fecha);
        $intervalo = $fechaCompromiso->diff($fechaPago);
        $dias = (int)$intervalo->format('%R%a');
        
        $deuda->diasRetraso = $dias > 0 ? $dias : 0;
        $deuda->estado = true;
        $deuda->save();

        return redirect('/arriendo/'.$deuda->arriendo->id);
    }

    public function descargarComprobante($id) {
        $pago = PagoDeuda::find($id);
        $url = base_path().'/storage/app/public/'.$pago->urlComprobante;
        $extension = pathinfo(storage_path($url), PATHINFO_EXTENSION);
        return \Response::download($url, 'comprobante.'.$extension);
    }

    public function reportarProblema(Request $request) {
        $deuda = Deuda::find($request->id);
        $deuda->estado = false;
        $deuda->save();
        return $deuda->arriendo->id;
    }

}
