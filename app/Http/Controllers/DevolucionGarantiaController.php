<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DevolucionGarantia;
use App\Garantia;
use App\DescuentoDevolucionGarantia;
use App\Http\Controllers\DescuentoDevolucionGarantiaController;

class DevolucionGarantiaController extends Controller
{

    public function configurar($id) {
        $garantia = Garantia::find($id);
        return view('devolucion.configurar', [
            'deuda' => $garantia,
            'monto' =>$garantia->monto,
            'url' => '/garantia/devolucion',
            'id' => $id
            ]);
    }

    public function registrar(Request $request) {
        $devolucion = new DevolucionGarantia();
        $devolucion->idGarantia = $request->id;
        $devolucion->monto = $request->disponible;
        $actual = new \DateTime();
        $devolucion->fecha = $actual->format('Y-m-d');
        $devolucion->urlComprobante = $request->file('documento')->store('devolucionesGarantia');
        $devolucion->save();
        $index = 1;
        while($request['v'.$index]) {
            DescuentoDevolucionGarantiaController::registrar((int)$request->id, (int)$request['v'.$index], $request['m'.$index]);
            $index++;
        }
        $devolucion->idGarantia = $request->id;
        if($devolucion->garantia->arriendo->calificacion->notaAlInquilino > 0) {
            $devolucion->garantia->arriendo->inmueble->idEstado = 1;
            $devolucion->garantia->arriendo->inmueble->save();
        }
        return redirect('/inmuebles');
    }

    public function descargarComprobante($id) {
        $devolucion = DevolucionGarantia::find($id);
        $url = base_path().'/storage/app/public/'.$devolucion->urlComprobante;
        $extension = pathinfo(storage_path($url), PATHINFO_EXTENSION);
        return \Response::download($url, 'comprobante.'.$extension);
    }
    
}
