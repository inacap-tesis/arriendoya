@php
$fechaCompromiso = new \DateTime($compromiso);
/*if($periodo->estado) {
    $fechaPago = new \DateTime($periodo->pagos->first()->fecha);
    if($fechaPago == $fechaCompromiso) {
        $cantidadDiasRetraso = 'Ninguno';
    } else {
        $intervalo = $fechaCompromiso->diff($fechaPago);
        $temp = (int)$intervalo->format('%R%a');
        $cantidadDiasRetraso = $temp > 0 ? number_format($temp, 0, ',', '.') : 'Ninguno';
    }
    
}*/
@endphp

<tr @if ($periodo->estado) class="table-success" @else class="table-active" @endif>
    <th scope="row">{{ $titulo }}</th>
    <td>{{ $periodo->estado ? $periodo->pagos->first()->fecha : 'Pendiente' }}</td>
    <td>{{ $fechaCompromiso->format('d-m-Y') }}</td>
    <td>{{ $periodo->estado ? $periodo->diasRetraso : '-' }}</td>
    <td>
        @if ($arriendo->inquilino->rut == Auth::user()->rut)
        
            <!--Opciones de inquilino-->
            @if ($periodo->estado)
            <a href="{{ '/'.$tipo.'/pago/comprobante/'.$periodo->pagos->first()->id }}" class="btn btn-primary">Descargar Comprobante</a>
            @elseif($permitirPagar)
            <a href="{{ '/'.$tipo.'/pago/'.$idPeriodo }}" class="btn btn-primary">{{ $tipo == 'deuda' ? 'Pagar Renta' : 'Pagar Garantía' }}</a>
            @endif
        
        @else

            <!--Opciones de propietario-->
            @if ($periodo->estado)
            <a href="{{ '/'.$tipo.'/pago/comprobante/'.$periodo->pagos->first()->id }}" class="btn btn-primary">Descargar Comprobante</a>
            @php $_tipo = "'".$tipo."'" @endphp
            <a href="#" class="btn btn-primary" onclick="reportarProblema({{ $idPeriodo.','.$periodo->pagos.','.$_tipo }})">Reportar Problema</a>
            @endif

        @endif
    </td>
</tr>