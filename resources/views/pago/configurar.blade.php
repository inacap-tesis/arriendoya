@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <form class="card" action="{{ $url }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <input type="hidden" name="id" value="{{ $id }}">
                <div class="card-header" style="font-weight: bold;">{{ __('Informar pago de Renta') }}</div>
                <div class="card-body">
                    <div class="form-row">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th scope="row">RUT</th>
                                    <td>{{ $deuda->arriendo->inmueble->propietario->rut }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Nombre completo</th>
                                    <td>{{ $deuda->arriendo->inmueble->propietario->primerNombre.' '.$deuda->arriendo->inmueble->propietario->segundoNombre.' '.$deuda->arriendo->inmueble->propietario->primerApellido.' '.$deuda->arriendo->inmueble->propietario->segundoApellido }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Correo electrónico</th>
                                    <td>{{ $deuda->arriendo->inmueble->propietario->email }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Banco</th>
                                    <td>{{ $deuda->arriendo->inmueble->propietario->cuentaBancaria->banco->nombre }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Tipo de cuenta</th>
                                    <td>{{ $deuda->arriendo->inmueble->propietario->cuentaBancaria->tipoCuenta->nombre }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Número de cuenta</th>
                                    <td>{{ $deuda->arriendo->inmueble->propietario->cuentaBancaria->numero }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Valor</th>
                                    <td>{{ '$ '.number_format($monto, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-row">
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="documento" name="documento" required>
                                <label class="custom-file-label" for="documento">Comprobante de pago...</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Pagar</button>
                    <a href="{{ '/arriendo/'.$deuda->arriendo->id }}" class="btn btn-primary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection