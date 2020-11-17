@extends('layouts.app')

@section('content')
<div class="container">
    @include('layouts.modal', [
      'static' => true,
      'size' => 'modal-lg'
      ])
    <div class="row">
        <div class="col text-center">
            <h2>Detalles del Arriendo</h2>
        </div>
    </div>
    <h5>Información</h5>
    <div class="row border border-primary">
        <div class="col">
            <p>
                {{ __($usuario->primerNombre.' '.$usuario->segundoNombre.' '.$usuario->primerApellido.' '.$usuario->segundoApellido) }}
            </p>
            <p>{{ __( $usuario->telefono) }}</p>
            <p>{{ __( $usuario->email) }}</p>
        </div>
        <div class="col">
            <p>{{ __('Fecha de inicio: '.$arriendo->fechaInicio) }}</p>
            <p>{{ __('Fecha de término: '.$arriendo->fechaTerminoReal) }}</p>
        </div>
        <div class="col">
            <ul>
                @if ($arriendo->urlContrato)
                <a href="{{ __('/arriendo/descargarContrato/'.$arriendo->id) }}" class="btn btn-primary">Descargar Contrato</a>
                @endif
                @php
                $deudas = $arriendo->deudas;
                $fechaActual = new \DateTime();
                $solicitudesRecibidas = $arriendo->solicitudesFinalizacion->where('fechaPropuesta', '>', $fechaActual->format('Y-m-d'))->where('rutReceptor',Auth::user()->rut)->whereNull('respuesta');
                $solicitudesEmitidas = $arriendo->solicitudesFinalizacion->where('fechaPropuesta', '>', $fechaActual->format('Y-m-d'))->where('rutEmisor', Auth::user()->rut)->whereNull('respuesta');
                $solicitudRechazada = $arriendo->solicitudesFinalizacion->where('fechaPropuesta', '>', $fechaActual->format('Y-m-d'))->where('rutEmisor', Auth::user()->rut)->first();
                @endphp
                @if (count($solicitudesRecibidas) > 0)
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" onclick="responderSolicitud({{ $solicitudesRecibidas->first() }})">
                    Responder Solicitud Finalización
                </button>
                @elseif(count($solicitudesEmitidas) == 0)
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" onclick="solicitarFinalizacion()">
                    Solicitar Finalización
                </button>
                @endif
                @if ($solicitudRechazada && $solicitudRechazada->estado == true && isset($solicitudRechazada->respuesta) && $solicitudRechazada->respuesta == false)
                <a href="#" class="btn btn-primary" onclick="finalizarForzosamente({{ $arriendo }})">Finalizar Forzosamente</a>
                @endif
            </ul>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Periodo</th>
                <th scope="col">Fecha de pago</th>
                <th scope="col">Fecha de compromiso</th>
                <th scope="col">Días retraso</th>
                <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody>
            
            @if ($arriendo->garantia)
            <!--Garantía-->
            @include('arriendo.periodo', [
                'periodo' => $arriendo->garantia,
                'compromiso' => $arriendo->fechaInicio,
                'titulo' => 'Garantía',
                'tipo' => 'garantia',
                'idPeriodo' => $arriendo->id,
                'permitirPagar' => true
            ])
            @php $permitirPagar = $arriendo->garantia->estado; @endphp
            @else
            @php $permitirPagar = true; @endphp
            @endif

            @foreach ($arriendo->deudas as $deuda)
            <!--Deuda-->
            @include('arriendo.periodo', [
                'periodo' => $deuda,
                'compromiso' => $deuda->fechaCompromiso,
                'titulo' => $deuda->titulo,
                'tipo' => 'deuda',
                'idPeriodo' => $deuda->id,
                'permitirPagar' => $permitirPagar
            ])
            @php $permitirPagar = $deuda->estado; @endphp
            @endforeach

        </tbody>
    </table>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    function solicitarFinalizacion() {
        $('#titleModal').text('Solicitar finalización de arriendo');
        
        var motivoDiv = $('<div class="form-group"></div>');
        var motivoLabel = $('<label for="motivo">Motivo</label>');
        var motivoTextarea = $('<textarea maxlength="255" class="form-control" id="motivo" name="motivo" rows="3" required></textarea>');
        var motivoMessage = $('<div id="msgMotivo" class="invalid-feedback"></div>');
        motivoDiv.append(motivoLabel, motivoTextarea, motivoMessage);

        var fechaDiv = $('<div class="form-group"></div>');
        var fechaLabel = $('<label for="fecha">Fecha propuesta</label>');
        var fechaInput = $('<input type="date" class="form-control" id="fecha" name="fecha" required>');
        var fechaMessage = $('<div id="msgFecha" class="invalid-feedback"></div>');
        fechaDiv.append(fechaLabel, fechaInput, fechaMessage);

        $('#bodyModal').empty();
        $('#bodyModal').append(motivoDiv, fechaDiv);

        var btnAceptar = $('<button type="submit" class="btn btn-primary" onclick="solicitar({{ $arriendo }})">Aceptar</button>');
        var btnCancelar = $('<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>');
        $('#footerModal').empty();
        $('#footerModal').append(btnAceptar, btnCancelar);

        $('#ventanaModal').modal('toggle');
    }

    function solicitar(arriendo) {
        
        var valid = true;

        $('#msgMotivo').empty();
        $('#msgFecha').empty();
        $('#motivo').removeClass('is-invalid');
        $('#fecha').removeClass('is-invalid');

        var motivo = $('#motivo').val();
        if(!motivo) {
            $('#msgMotivo').text('Es necesario indicar el motivo.');
            $('#motivo').addClass('is-invalid');
            valid = false; 
        }

        var fecha = $('#fecha').val();
        if(!fecha) {
            $('#msgFecha').text('La fecha de obligatoria.');
            $('#fecha').addClass('is-invalid');
            valid = false;
        }

        fecha = new Date(fecha + ' 00:00:00');
        var max = new Date(arriendo.fechaTerminoReal + ' 00:00:00');
        var min = new Date();
        var temp = false;
        for (var i = 0; i < arriendo.deudas.length; i++) {
            if(temp) {
                min = new Date(arriendo.deudas[i].fechaCompromiso + ' 23:59:59');
                min.setDate(min.getDate() - 1);
                break;
            }
            temp = arriendo.deudas[i].estado;
        }

        if(fecha < min || fecha > max) {
            $('#msgFecha').text('La fecha debe ser mayor que ' + min.toLocaleDateString('es') + ' y menor que ' + max.toLocaleDateString('es'));
            $('#fecha').addClass('is-invalid');
            valid = false;
        }

        if(valid) {
            fecha = $('#fecha').val();
            $.ajax({
                url: '/solicitud',
                type: "POST",
                dataType: 'json',//this will expect a json response
                data: {
                  '_token': '{{ csrf_token() }}',
                  id: arriendo.id,
                  motivo: motivo,
                  fecha: fecha
                }, 
                success: function(response) {
                    $('#ventanaModal').modal('toggle');
                    window.location.href = "/arriendo/" + response;
                }
            });
        }
    }

    function responderSolicitud(solicitud) {
        $('#titleModal').text('Responder solicitud');

        var fecha = new Date(solicitud.fechaPropuesta);
        fecha.setDate(fecha.getDate() + 1);
        var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        var pregunta = $('<p>¿Está de acuerdo en finalizar el arriendo el ' + fecha.toLocaleDateString('es', options) + '?</p>');

        $('#bodyModal').empty();
        $('#bodyModal').append(pregunta);

        var btnAceptar = $('<button type="submit" class="btn btn-primary" onclick="responder(' + solicitud.id + ', true)">Aceptar</button>');
        var btnRechazar = $('<button type="submit" class="btn btn-primary" onclick="responder(' + solicitud.id + ', false)">Rechazar</button>');
        $('#footerModal').empty();
        $('#footerModal').append(btnAceptar, btnRechazar);

        $('#ventanaModal').modal('toggle');
    }

    function responder(id, respuesta) {
        $.ajax({
            url: '/solicitud',
            type: "PUT",
            dataType: 'json',//this will expect a json response
            data: {
              '_token': '{{ csrf_token() }}',
              id,
              respuesta
            }, 
            success: function(response) {
                $('#ventanaModal').modal('toggle');
                window.location.href = "/arriendo/" + response;
            }
        });
    }

    function reportarProblema(idPeriodo, pagos, tipo) {
        console.log('ok');
        $('#titleModal').text('Reportar problema con el pago');
        
        var motivoDiv = $('<div class="form-group"></div>');
        var motivoLabel = $('<label for="motivo">¿Qué problema tiene con el pago?</label>');
        var motivoTextarea = $('<textarea maxlength="255" class="form-control" id="motivo" name="motivo" rows="3" required></textarea>');
        var motivoMessage = $('<div id="msgMotivo" class="invalid-feedback"></div>');
        motivoDiv.append(motivoLabel, motivoTextarea, motivoMessage);

        var p = $('<p>Por favor considere los siguientes comprobantes:</p>');
        var ul = $('<ul></ul>');
        $index = pagos.length;
        pagos.map(pago => {
            var fecha = new Date(pago.fecha + ' 00:00:00');
            var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            var li = $('<li><a href="/' + tipo + '/pago/comprobante/' + pago.id + '">#' + $index + ' Enviado el ' + fecha.toLocaleDateString('es', options) + '</a></li>');
            ul.append(li);
            $index--;
        });

        $('#bodyModal').empty();
        $('#bodyModal').append(motivoDiv, p, ul);

        _tipo = "'" + tipo + "'";
        var btnAceptar = $('<button type="submit" class="btn btn-primary" onclick="reportar(' + idPeriodo + ',' + _tipo + ')">Aceptar</button>');
        var btnCancelar = $('<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>');
        $('#footerModal').empty();
        $('#footerModal').append(btnAceptar, btnCancelar);

        $('#ventanaModal').modal('toggle');
    }

    function reportar(id, tipo) {

        $('#msgMotivo').empty();
        $('#motivo').removeClass('is-invalid');

        var motivo = $('#motivo').val();
        if(!motivo) {
            $('#msgMotivo').text('Es necesario explicar el problema.');
            $('#motivo').addClass('is-invalid');
        }

        if(motivo) {
            $.ajax({
                url: '/' + tipo + '/pago/problema',
                type: "POST",
                dataType: 'json',//this will expect a json response
                data: {
                  '_token': '{{ csrf_token() }}',
                  id,
                  motivo
                }, 
                success: function(response) {
                    $('#ventanaModal').modal('toggle');
                    window.location.href = "/arriendo/" + response;
                }
            });
        }
    }

    function finalizarForzosamente(arriendo) {
        $('#titleModal').text('Finalizar Forzosamente');

        var p1 = $('<p>Antes de continuar, permítanos recomendarle lo siguiente:</p>');
        var ul = $('<ul></ul>');
        var fecha = new Date(arriendo.solicitudes_finalizacion[0].fechaPropuesta + ' 00:00:00');
        var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        ul.append($('<li>Si acepta, el arriendo finalizará el ' + fecha.toLocaleDateString('es', options) + ', de acuerdo a la última solicitud rechazada.</li>'));
        ul.append($('<li>Recomendación 1</li>'));
        ul.append($('<li>Recomendación 2</li>'));
        ul.append($('<li>Recomendación n</li>'));
        ul.append($('<li>Recomendación .</li>'));
        ul.append($('<li>Recomendación .</li>'));
        var p2 = $('<p>¿Está seguro de finalizar el arriendo forzosamente?</p>');

        $('#bodyModal').empty();
        $('#bodyModal').append(p1, ul, p2);

        var btnSi = $('<button type="submit" class="btn btn-primary" onclick="finalizar(' + arriendo.id + ')">Si</button>');
        var btnNo = $('<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>');
        $('#footerModal').empty();
        $('#footerModal').append(btnSi, btnNo);

        $('#ventanaModal').modal('toggle');
    }

    function finalizar(id) {
        $.ajax({
            url: '/arriendo/finalizar',
            type: "POST",
            dataType: 'json',//this will expect a json response
            data: {
              '_token': '{{ csrf_token() }}',
              id
            }, 
            success: function(response) {
                $('#ventanaModal').modal('toggle');
                window.location.href = "/arriendo/" + response;
            }
        });
    }
</script>
@endsection