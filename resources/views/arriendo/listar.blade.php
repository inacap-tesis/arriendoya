@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h3 class="col">Mis Arriendos</h3>
    </div>
    <br>
    <div class="row row-cols-1 row-cols-md-3">
        @foreach ($arriendos as $arriendo)

        @switch($arriendo->inmueble->idTipoInmueble)
            @case(1)
                @php $tipo = 'Casa'; @endphp
                @break
            @case(2)
              @php $tipo = 'Departamento'; @endphp
                @break
            @case(3)
              @php $tipo = 'Habitación'; @endphp  
                @break
            @default
              @php $tipo = ''; @endphp  
        @endswitch

        @php
            $color = 'danger';
            $botones = [];
            if($arriendo->estado) {
                $color = 'success';
                array_push($botones, array('Ver arriendo', '/arriendo'));
            } elseif(!$arriendo->calificacion || $arriendo->calificacion->notaAlArriendo == 0) {
                array_push($botones, array('Calificar arriendo', '/calificacion'));
                if($arriendo->garantia && $arriendo->garantia->devolucion) {
                    array_push($botones, array('Descargar comprobante', '/garantia/devolucion/comprobante'));
                }
            } elseif($arriendo->garantia && $arriendo->garantia->devolucion) {
                array_push($botones, array('Descargar comprobante', '/garantia/devolucion/comprobante'));
            } else {
                continue;
            }
        @endphp

        @include('inmueble.item', [
            'direccion' => $arriendo->inmueble->calleDireccion.' '.$arriendo->inmueble->numeroDireccion,
            'elemento' => $arriendo,
            'esArriendo' => true,
            'color' => $color,
            'botones' => $botones,
            'tipo' => $tipo,
            'id' => $arriendo->id
        ])

        @endforeach
    </div>
</div>
@endsection