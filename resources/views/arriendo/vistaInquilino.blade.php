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
                {{ __($arriendo->inmueble->propietario->primerNombre.' '.$arriendo->inmueble->propietario->segundoNombre.' '.$arriendo->inmueble->propietario->primerApellido.' '.$arriendo->inmueble->propietario->segundoApellido) }}
            </p>
            <p>{{ __( $arriendo->inmueble->propietario->telefono) }}</p>
            <p>{{ __( $arriendo->inmueble->propietario->email) }}</p>
        </div>
        <div class="col">
            <p>{{ __('Fecha de inicio: '.$arriendo->fechaInicio) }}</p>
            <p>{{ __('Fecha de término: '.$arriendo->fechaTerminoPropuesta) }}</p>
        </div>
        <div class="col">
            <ul>
                <a href="{{ __('/arriendo/descargarContrato/'.$arriendo->id) }}" class="btn btn-primary">Descargar Contrato</a>
                @php
                    $solicitudesRecibidas = $arriendo->solicitudesFinalizacion->where('rutReceptor',Auth::user()->rut)->whereNull('respuesta');
                    $solicitudesEmitidas = $arriendo->solicitudesFinalizacion->where('rutEmisor', Auth::user()->rut)->whereNull('respuesta');
                    $solicitudesRechazadas = $arriendo->solicitudesFinalizacion->where('rutEmisor', Auth::user()->rut)->first();
                @endphp
                @if (count($solicitudesRecibidas) > 0)
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" onclick="responderSolicitud({{ $solicitudesRecibidas->first() }})">
                    Responder Solicitud Finalización
                </button>
                @elseif(count($solicitudesEmitidas) == 0)
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" onclick="solicitarFinalizacion({{ $arriendo }})">
                    Solicitar Finalización
                </button>
                @endif
                @if ($solicitudesRechazadas && $solicitudesRechazadas->respuesta == 'false')
                {{$solicitudesRechazadas->respuesta}}
                <a href="#" class="btn btn-primary">Finalizar Forzosamente</a>
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
                <th scope="col">Días de retraso</th>
                <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @if ($arriendo->garantia)
            @php
            if($arriendo->garantia->estado) {
                $fechaPago = $arriendo->garantia->pagos->first()->fecha;
                $pagado = new \DateTime($fechaPago);
                $compromiso = new \DateTime($arriendo->fechaInicio);
                if($pagado == $compromiso) {
                    $cantidadDiasRetraso = 0;
                } else {
                    $diferencia = $pagado->diff($compromiso);
                    $cantidadDiasRetraso = (($diferencia->y * 12) * 30) + ($diferencia->m * 30) + $diferencia->d;
                    $cantidadDiasRetraso *= ($pagado > $compromiso ? 1 : -1);
                }
            }
            @endphp
            <tr @if ($arriendo->garantia->estado) class="table-success" @else class="table-active" @endif>
                <th scope="row">{{ __('Garantía') }}</th>
                <td>{{ $arriendo->garantia->estado ? date('d-m-Y', strtotime($fechaPago)) : 'Pendiente' }}</td>
                <td>{{ date('d-m-Y', strtotime($arriendo->fechaInicio)) }}</td>
                <td>{{ $arriendo->garantia->estado ? number_format($cantidadDiasRetraso, 0, ',', '.') : '-' }}</td>
                <td>
                    @if ($arriendo->garantia->estado)
                    <a href="{{ '/garantia/pago/comprobante/'.$arriendo->garantia->id }}" class="btn btn-primary">Descargar Comprobante</a>
                    @else
                    <a href="{{ '/garantia/pagar/'.$arriendo->garantia->idArriendo }}" class="btn btn-primary">Pagar Garantía</a>
                    @endif
                </td>
            </tr>
            @endif
            @foreach ($arriendo->deudas as $deuda)
            @php
            if($deuda->estado) {
                $fechaPago = $deuda->pagos->first()->fecha;
                $pagado = new \DateTime($fechaPago);
                $compromiso = new \DateTime($deuda->fechaCompromiso);
                if($pagado == $compromiso) {
                    $cantidadDiasRetraso = 0;
                } else {
                    $diferencia = $pagado->diff($compromiso);
                    $cantidadDiasRetraso = (($diferencia->y * 12) * 30) + ($diferencia->m * 30) + $diferencia->d;
                    $cantidadDiasRetraso *= ($pagado > $compromiso ? 1 : -1);
                }
            }
            @endphp
            <tr @if ($deuda->estado) class="table-success" @else class="table-active" @endif>
                <th scope="row">{{ $deuda->titulo }}</th>
                <td>{{ $deuda->estado ? date('d-m-Y', strtotime($fechaPago)) : 'Pendiente' }}</td>
                <td>{{ date('d-m-Y', strtotime($deuda->fechaCompromiso)) }}</td>
                <td>{{ $deuda->estado ? number_format($cantidadDiasRetraso, 0, ',', '.') : '-' }}</td>
                <td>
                    @if ($deuda->estado)
                    <a href="{{ '/deuda/pago/comprobante/'.$deuda->id }}" class="btn btn-primary">Descargar Comprobante</a>
                    @else
                    <a href="{{ '/deuda/pago/'.$deuda->id }}" class="btn btn-primary">Pagar Renta</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    function solicitarFinalizacion(arriendo) {
        
        $('#titleModal').text('Solicitar finalización de arriendo');
        
        var motivoDiv = $('<div class="form-group"></div>');
        var motivoLabel = $('<label for="motivo">Motivo</label>');
        var motivoTextarea = $('<textarea class="form-control" id="motivo" name="motivo" rows="3" required></textarea>');
        var motivoMessage = $('<div class="invalid-feedback">Campo requerido</div>');
        motivoDiv.append(motivoLabel, motivoTextarea, motivoMessage);

        var fechaDiv = $('<div class="form-group"></div>');
        var fechaLabel = $('<label for="fecha">Fecha propuesta</label>');
        var fechaInput = $('<input type="date" class="form-control" id="fecha" name="fecha" required>');
        var fechaMessage = $('<div class="invalid-feedback">Campo requerido</div>');
        fechaDiv.append(fechaLabel, fechaInput, fechaMessage);

        $('#bodyModal').empty();
        $('#bodyModal').append(motivoDiv, fechaDiv);

        var btnAceptar = $('<button type="submit" class="btn btn-primary" onclick="solicitar(' + arriendo.id + ')">Aceptar</button>');
        var btnCancelar = $('<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>');
        $('#footerModal').empty();
        $('#footerModal').append(btnAceptar, btnCancelar);

        $('#ventanaModal').modal('toggle');
    }

    function solicitar(id) {
        var motivo = $('#motivo').val();
        if(!motivo) {
            $('#motivo').addClass('is-invalid');
        } else {
            $('#motivo').removeClass('is-invalid');
        }

        var fecha = $('#fecha').val();
        if(!fecha) {
            $('#fecha').addClass('is-invalid');
        } else {
            $('#fecha').removeClass('is-invalid');
        }

        if(motivo && fecha) {
            $.ajax({
                url: '/solicitud',
                type: "POST",
                dataType: 'json',//this will expect a json response
                data: {
                  '_token': '{{ csrf_token() }}',
                  id,
                  motivo,
                  fecha
                }, 
                success: function(response) {
                    $('#ventanaModal').modal('toggle');
                    window.location.href = "/arriendo/inquilino/" + response;
                    console.log(response);
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
                window.location.href = "/arriendo/inquilino/" + response;
                console.log(response);
            }
        });
    }
</script>
@endsection