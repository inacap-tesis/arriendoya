@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header" style="font-weight: bold;">{{ __('Configurar Arriendo') }}</div>
                <div class="card-body">
                    <form id="formulario" action="/arriendo" method="POST">
                        @csrf
                        @if ($arriendo)
                        @method('PUT')
                        <input type="hidden" name="arriendo" value="{{ $arriendo->id }}">
                        @else
                        <input type="hidden" name="inmueble" value="{{ $anuncio }}">
                        @endif
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="inquilino">Inquilino</label>
                                <select class="form-control" id="inquilino" name="inquilino" required>
                                    @foreach ($intereses as $interes)
                                    <option value="{{ $interes->usuario->rut }}" @if($arriendo && $arriendo->rutInquilino == $interes->usuario->rut) selected @endif>{{ $interes->usuario->primerNombre.' '.$interes->usuario->primerApellido }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="fechaInicio">Fecha de inicio</label>
                                <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" @if($arriendo) value="{{ $arriendo->fechaInicio }}" @endif onchange="validarFechaInicio()" required>
                                <span class="invalid-feedback" role="alert">
                                    <strong id="_fechaInicio"></strong>
                                </span>
                            </div>
                            <div class="form-group col">
                                <label for="fechaFin">Fecha de término</label>
                                <input type="date" class="form-control" id="fechaFin" name="fechaFin" @if($arriendo) value="{{ $arriendo->fechaTerminoReal }}" @endif onchange="validarFechaTermino()" required>
                                <span class="invalid-feedback" role="alert">
                                    <strong id="_fechaFin"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="canon">{{ __('Renta mensual') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                      <div class="input-group-text">$</div>
                                    </div>
                                    <input type="number" min="1" max="8000000" class="form-control" id="canon" name="canon" @if($arriendo) value="{{ $arriendo->canon }}" @endif required>
                                    <span class="invalid-feedback" role="alert">
                                        <strong id="_canon"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col">
                                <label for="diaPago">{{ __('Día de pago') }}</label>
                                <input type="number" min="1" max="28" class="form-control" id="diaPago" name="diaPago" @if($arriendo) value="{{ $arriendo->diaPago }}" @endif required>
                                <span class="invalid-feedback" role="alert">
                                    <strong id="_diaPago"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" min="1" max="8000000" id="conGarantia" name="conGarantia" onchange="tieneGarantia()" style="margin-top: 5px;" @if($arriendo && $arriendo->garantia) checked @endif>
                                            <label class="form-check-label" for="conGarantia">
                                                Incluye garantía
                                            </label>
                                          </div>
                                    </div>
                                    <div class="input-group-text">$</div>
                                  </div>
                                  <input type="number" min="0" class="form-control" id="garantia" name="garantia" placeholder="¿Cuanto?" @if($arriendo && $arriendo->garantia) value="{{ $arriendo->garantia->monto }}" @else disabled @endif>
                                  <span class="invalid-feedback" role="alert">
                                      <strong id="_garantia"></strong>
                                  </span>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="btn btn-primary" onclick="enviar()">Aceptar</a>
                        <a href="/inmuebles" class="btn btn-primary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    function tieneGarantia() {
        $('#garantia').attr('disabled', !$('#conGarantia')[0].checked);
        $('#garantia').attr('required', $('#conGarantia')[0].checked);
    }

    function isValid(name, msg) {
        if(!$('#'+ name).val()){
            $('#' + name).addClass('is-invalid');
            $('#_' + name).empty();
            $('#_' + name).text(msg);
            return false;
        } else {
            $('#' + name).removeClass('is-invalid');
            $('#_' + name).empty();
        }
        return true;
    }

    function enviar() {
        var valid = true;
        valid = isValid('fechaInicio', 'Por favor ingrese la fecha de inicio.');
        valid = isValid('fechaFin', 'Por favor ingrese la fecha de término.');
        valid = isValid('canon', 'Por favor ingrese el canon.');
        valid = isValid('diaPago', 'Por favor ingrese el día de pago.');
        if($('#conGarantia').prop('checked') && !$('#garantia').val()){
            valid = isValid('garantia', 'Por favor ingrese la garantía.');
        }
        
        if(valid && validarFechaInicio() && validarFechaTermino()) {
            $('#formulario').submit();
        }
    }

    function validarFechaInicio() {
        if(isValid('fechaFin', 'Por favor ingrese la fecha de término.')){
            var fecha = new Date($('#fechaInicio').val() + ' 00:00:00');
            var fechaFin = new Date($('#fechaFin').val() + ' 00:00:00');
            if(fecha > fechaFin) {
                $('#fechaInicio').addClass('is-invalid');
                $('#_fechaInicio').empty();
                $('#_fechaInicio').text('Esta fecha debe ser menor que la fecha de término.');
                return false;
            }
        }
        return true;
    }

    function validarFechaTermino() {
        var fecha = new Date($('#fechaFin').val() + ' 00:00:00');
        var fechaActual = new Date();
        if(fecha < fechaActual) {
            $('#fechaFin').addClass('is-invalid');
            $('#_fechaFin').empty();
            $('#_fechaFin').text('La fecha debe ser mayo que la actual.');
            return false;
        } else {
            if(isValid('fechaInicio', 'Por favor ingrese la fecha de inicio.')){
                var fechaInicio = new Date($('#fechaInicio').val() + ' 00:00:00');
                if(fecha < fechaInicio) {
                    $('#fechaFin').addClass('is-invalid');
                    $('#_fechaFin').empty();
                    $('#_fechaFin').text('Esta fecha debe ser mayo que la fecha de inicio.');
                    return false;
                }
            }
            $('#fechaFin').removeClass('is-invalid');
            $('#_fechaFin').empty();
        }
        return true;
    }
</script>
@endsection