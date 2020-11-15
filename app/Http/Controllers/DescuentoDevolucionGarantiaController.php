<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DescuentoDevolucionGarantia;
use App\DevolucionGarantia;

class DescuentoDevolucionGarantiaController extends Controller
{

    public function consultar() {

    }

    public static function registrar(int $devolucion, int $monto, string $motivo) {
        $descuento = new DescuentoDevolucionGarantia();
        $descuento->idDevolucionGarantia = $devolucion;
        $descuento->monto = $monto;
        $descuento->motivo = $motivo;
        return $descuento->save();
    }
    
}
