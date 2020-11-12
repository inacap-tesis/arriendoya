@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/arriendo" method="POST">
        @csrf
        @if ($arriendo)
        @method('PUT')
        <input type="hidden" name="arriendo" value="{{ $arriendo->id }}">
        @else
        <input type="hidden" name="inmueble" value="{{ $anuncio }}">
        @endif
        <div class="form-group">
            <label for="inquilino">Inquilino</label>
            <select class="form-control" id="inquilino" name="inquilino" required>
                @foreach ($intereses as $interes)
                <option value="{{ $interes->usuario->rut }}" @if($arriendo && $arriendo->rutInquilino == $interes->usuario->rut) selected @endif>{{ $interes->usuario->primerNombre.' '.$interes->usuario->primerApellido }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="fechaInicio">Fecha inicial del arriendo</label>
            <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" @if($arriendo) value="{{ $arriendo->fechaInicio }}" @endif required>
        </div>
        <div class="form-group">
            <label for="fechaFin">Fecha término del arriendo</label>
            <input type="date" class="form-control" id="fechaFin" name="fechaFin" @if($arriendo) value="{{ $arriendo->fechaTerminoPropuesta }}" @endif required>
        </div>
        <div class="form-group">
            <label for="canon">{{ __('Renta mensual') }}</label>
            <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">$</div>
                </div>
                <input type="number" min="0" class="form-control" id="canon" name="canon" @if($arriendo) value="{{ $arriendo->canon }}" @endif required>
            </div>
        </div>
        <div class="form-group">
            <label for="diaPago">{{ __('Día de pago') }}</label>
            <input type="number" min="1" max="28" class="form-control" id="diaPago" name="diaPago" @if($arriendo) value="{{ $arriendo->diaPago }}" @endif required>
        </div>
        <div class="row">
            <div class="col">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="conGarantia" name="conGarantia" onchange="tieneGarantia()" style="margin-top: 5px;" @if($arriendo && $arriendo->garantia) checked @endif>
                            <label class="form-check-label" for="conGarantia">
                                Incluye garantía
                            </label>
                          </div>
                    </div>
                    <div class="input-group-text">$</div>
                  </div>
                  <input type="number" min="0" class="form-control" id="garantia" name="garantia" placeholder="¿Cuanto?" @if($arriendo && $arriendo->garantia) value="{{ $arriendo->garantia->monto }}" @else disabled @endif>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Aceptar</button>
        <a href="/inmuebles" class="btn btn-primary">Cancelar</a>
    </form>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
    function tieneGarantia() {
        $('#garantia').attr('disabled', !$('#conGarantia')[0].checked);
        $('#garantia').attr('required', $('#conGarantia')[0].checked);
    }
    </script>
@endsection