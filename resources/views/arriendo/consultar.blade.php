@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col text-center">
            <h2>Detalles del Arriendo</h2>
        </div>
    </div>
    <h5>Información</h5>
    <div class="row border border-primary">
        <div class="col">
            <p>
                {{ __($arriendo->inmueble->propietario->primerNombre.' '.$arriendo->inmueble->propietario->segundoNombre.' '.$arriendo->inmueble->propietario->primerApellido.' '.$arriendo->inmueble->propietario->segundoApellido) }}
            </p>
            <p>{{ __( $arriendo->inmueble->propietario->telefono) }}</p>
            <p>{{ __( $arriendo->inmueble->propietario->email) }}</p>
        </div>
        <div class="col">
            <p>{{ __('Características del inmueble: '.$arriendo->inmueble->caracteristicas) }}</p>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Periodo</th>
                <th scope="col">Fecha de pago</th>
                <th scope="col">Fecha de compromiso</th>
                <th scope="col">Días de retraso</th>
                <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($arriendo->deudas as $deuda)
            <tr @if ($deuda->fechaPago) class="table-success" @else class="table-active" @endif>
                <th scope="row">{{ $deuda->titulo }}</th>
                <td>{{ $deuda->fechaPago ? date('d-m-Y', strtotime($deuda->fechaPago)) : 'Pendiente' }}</td>
                <td>{{ date('d-m-Y', strtotime($deuda->fechaCompromiso)) }}</td>
                <td>{{ $deuda->cantidadDiasRetraso ? number_format($deuda->cantidadDiasRetraso, 0, ',', '.') : '-' }}</td>
                <td>
                    @if ($deuda->fechaPago)
                    <a href="{{ '/deuda/comprobante/'.$deuda->id }}" class="btn btn-primary">Descargar Comprobante</a>
                    @else
                    <a href="{{ '/deuda/pagar/'.$deuda->id }}" class="btn btn-primary">Pagar Renta</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection