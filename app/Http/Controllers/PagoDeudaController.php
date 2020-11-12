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
        return view('deuda.pagar', ['deuda' => $deuda]);
    }

    public function registrar(Request $request) {
        $deuda = Deuda::find($request->deuda);
        $deuda->estado = true;
        if($deuda->save()) {
            $pago = new PagoDeuda();
            $pago->idDeuda = $deuda->id;
            $actual = new \DateTime();
            $pago->fecha = $actual->format('Y-m-d');
            $pago->urlComprobante = $request->file('documento')->store('pagosDeuda');
            $pago->save();
        }

        return redirect('/arriendo/inquilino/'.$deuda->arriendo->id);
    }

    public function descargarComprobante($id) {
        $deuda = Deuda::find($id);
        $pago = $deuda->pagos->first();
        $url = base_path().'/storage/app/public/'.$pago->urlComprobante;
        $extension = pathinfo(storage_path($url), PATHINFO_EXTENSION);
        $fecha = new \DateTime($deuda->fechaCompromiso);
        $fecha->modify('+1 month');
        $mes = CatalogoController::consultarMes((int)$fecha->format('m'));
        //$headers = array('Content-Type: application/pdf');
        return \Response::download($url, $mes.'.'.$extension);
    }

    public function reportarProblema($id) {
        return view('notificacion.configurar', [
            'id' => $id,
            'tipo' => 1,
            'rut' => Deuda::find($id)->arriendo->inquilino->rut
        ]);
    }

}
