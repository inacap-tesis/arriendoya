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

        return redirect('/arriendo/'.$deuda->arriendo->inmueble->id);
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
        return $deuda->arriendo->inmueble->id;
        /*return view('notificacion.configurar', [
            'id' => $id,
            'tipo' => 1,
            'rut' => Deuda::find($id)->arriendo->inquilino->rut
        ]);*/
    }

}
