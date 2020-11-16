<?php

namespace App\Http\Controllers;

use App\Notifications\DeudaNotificacion;
use Illuminate\Http\Request;
use App\Deuda;
use App\PagoDeuda;
use App\Notificacion;

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
        //Notificar al propietario
        $deuda->arriendo->inmueble->propietario->notify(new DeudaNotificacion($deuda, $deuda->arriendo->inquilino, 3));

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
        //Notificar al inquilino
        $deuda->arriendo->inquilino->notify(new DeudaNotificacion($deuda, $deuda->arriendo->inmueble->propietario, 4, $request->motivo));
        return $deuda->arriendo->id;
    }

}
