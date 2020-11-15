@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="text-center">Realizar pago</h4>
    <br>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
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
    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <form action="{{ $url }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <input type="hidden" name="id" value="{{ $id }}">
                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="documento" name="documento" required>
                        <label class="custom-file-label" for="documento">Comprobante de pago...</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Pagar</button>
                <a href="{{ '/arriendo/'.$deuda->arriendo->id }}" class="btn btn-primary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection