@extends('layouts.app')

@section('content')
<div class="container">
    @include('layouts.modal', [
      'static' => true,
      'size' => null
      ])
      <div class="row">
          <div class="col">
            <form class="card" action="{{ $url }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $id }}">
                <div class="card-header" style="font-weight: bold;">{{ __('Informar devolución de garantía') }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th scope="row">RUT</th>
                                        <td>{{ $deuda->arriendo->inquilino->rut }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Nombre completo</th>
                                        <td>{{ $deuda->arriendo->inquilino->primerNombre.' '.$deuda->arriendo->inquilino->segundoNombre.' '.$deuda->arriendo->inquilino->primerApellido.' '.$deuda->arriendo->inquilino->segundoApellido }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Correo electrónico</th>
                                        <td>{{ $deuda->arriendo->inquilino->email }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Banco</th>
                                        <td>{{ $deuda->arriendo->inquilino->cuentaBancaria->banco->nombre }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Tipo de cuenta</th>
                                        <td>{{ $deuda->arriendo->inquilino->cuentaBancaria->tipoCuenta->nombre }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Número de cuenta</th>
                                        <td>{{ $deuda->arriendo->inquilino->cuentaBancaria->numero }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Valor</th>
                                        <td>{{ '$ '.number_format($monto, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col">
                                    <button class="btn btn-success" onclick="agregarDescuento()">Agregar descuento</button>
                                </div>
                                <!--<div class="col text-right">
                                    <h6 style="margin-top: 15px"><b id="totalDisponible">$ 0 </b><span> a devolver</span></h6>
                                </div>-->
                            </div>
                            <br>
                            <div class="row">
                                <div class="col">
                                    <h5>Lista de descuentos</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <input id="disponible" name="disponible" type="hidden" value="0">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Monto</th>
                                                <th colspan="2">Motivo</th>
                                            </tr>
                                        </thead>
                                        <tbody id="lista">    
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="documento" name="documento" required>
                                    <label class="custom-file-label" for="documento">Comprobante de pago...</label>
                                </div>
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
@section('scripts')
<script type="text/javascript">

    function agregarDescuento() {
        $('#titleModal').text('Descuento de garantía');
        
        var valorDiv = $('<div class="form-group"></div>');
        var valorLabel = $('<label for="valor">Valor</label>');
        var valorInput = $('<input type="number" min="0" class="form-control" id="valor" required>');
        var valorMessage = $('<div id="msgValor" class="invalid-feedback"></div>');
        valorDiv.append(valorLabel, valorInput, valorMessage);

        var motivoDiv = $('<div class="form-group"></div>');
        var motivoLabel = $('<label for="motivo">Motivo</label>');
        var motivoTextarea = $('<textarea class="form-control" id="motivo" name="motivo" rows="3" required></textarea>');
        var motivoMessage = $('<div id="msgMotivo" class="invalid-feedback"></div>');
        motivoDiv.append(motivoLabel, motivoTextarea, motivoMessage);

        var valorDiv = $('<div class="form-group"></div>');
        var valorLabel = $('<label for="valor">Valor</label>');
        var valorInput = $('<input type="number" min="0" class="form-control" id="valor" required>');
        var valorMessage = $('<div id="msgValor" class="invalid-feedback"></div>');
        valorDiv.append(valorLabel, valorInput, valorMessage);

        $('#bodyModal').empty();
        $('#bodyModal').append(valorDiv, motivoDiv);

        var btnAgregar = $('<button type="submit" class="btn btn-primary" onclick="agregar()">Agregar</button>');
        var btnCancelar = $('<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>');
        $('#footerModal').empty();
        $('#footerModal').append(btnAgregar, btnCancelar);

        $('#ventanaModal').modal('toggle');
    }

    function agregar() {

        var valid = true;

        $('#msgMotivo').empty();
        $('#msgValor').empty();
        $('#motivo').removeClass('is-invalid');
        $('#valor').removeClass('is-invalid');

        var valor = $('#valor').val();
        if(!valor) {
            $('#msgValor').text('El valor de obligatorio.');
            $('#valor').addClass('is-invalid');
            valid = false;
        }

        var temp = procesarMonto(valor);
        var index = temp.index + 1;
        if(!temp.valid) {
            $('#msgValor').text('El valor debe ser menor o igual a $' + temp.disponible.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            $('#valor').addClass('is-invalid');
            valid = false;
        }

        var motivo = $('#motivo').val();
        if(!motivo) {
            $('#msgMotivo').text('Es necesario indicar el motivo.');
            $('#motivo').addClass('is-invalid');
            valid = false; 
        }

        if(valid) {
            var tr = $('<tr id="row' + index + '"></tr>');
            $('#disponible').val(temp.disponible - parseInt(valor));
            var tdIndex = $('<td>' + index + '</td>');
            var inputValor = $('<input id="v' + index + '" name="v' + index + '" type="hidden" value="' + valor + '">');
            var tdValor = $('<td>$' + valor.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + '</td>');
            tdValor.append(inputValor);
            var inputMotivo = $('<input id="m' + index + '" name="m' + index + '" type="hidden" value="' + motivo + '">');
            var trMotivo = $('<td>' + motivo + '</td>');
            trMotivo.append(inputMotivo);
            var trBtn = $('<td></td>');
            var btn = $('<a href="#" class="btn btn-danger" onclick="eliminar(' + index + ')">Eliminar</a>');
            trBtn.append(btn);
            tr.append(tdIndex, tdValor, trMotivo, trBtn);
            console.log(temp.disponible);
            /*var disponible = temp.disponible - parseInt(valor);
            $('#totalDisponible').text('$ ' + disponible.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));*/
            $('#lista').append(tr);
            $('#ventanaModal').modal('toggle');
        }

    }

    function procesarMonto(valor) {
        var garantia = {{ $monto }};
        var index = 0;
        var suma = parseInt(valor);
        do {
            var puntero = $('#v' + (index + 1)).val();
            if(!puntero) {
                break;
            }
            suma += parseInt(puntero);
            index++;
        } while(puntero);
        var diferencia = garantia - suma;
        var ingresados = suma - valor;
        var disponible = garantia - ingresados;
        return { 
            index,
            valid: diferencia >= 0,
            disponible
        };
    }

    function eliminar(index) {
        $('#row' + index).remove();
    }
</script>
@endsection