@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/arriendo/configurar" method="POST">
        @csrf
        @method('POST')
        <input type="hidden" name="inmueble" value="{{$inmueble->id}}">
        <div class="form-group">
            <label for="inquilino">Inquilino</label>
            <select class="form-control" id="inquilino" name="inquilino" required>
                @foreach ($intereses as $interes)
                <option value="{{ $interes->usuario->rut }}">{{ $interes->usuario->primerNombre.' '.$interes->usuario->primerApellido }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="fechaInicio">Fecha inicial del arriendo</label>
            <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" required>
        </div>
        <div class="form-group">
            <label for="fechaFin">Fecha término del arriendo</label>
            <input type="date" class="form-control" id="fechaFin" name="fechaFin" required>
        </div>
        <div class="form-group">
            <label for="canon">{{ __('Renta mensual') }}</label>
            <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">$</div>
                </div>
                <input type="number" min="0" class="form-control" id="canon" name="canon" required>
            </div>
        </div>
        <div class="form-group">
            <label for="diaPago">{{ __('Día de pago') }}</label>
            <input type="number" min="1" max="28" class="form-control" id="diaPago" name="diaPago" required>
        </div>
        <div class="row">
            <div class="col">
                <label>¿Incluye garantía?</label>
            </div>
            <div class="form-check col">
              <input class="form-check-input" type="radio" name="incluyeGarantia" id="siG" value="true">
              <label class="form-check-label" for="siG">Si</label>
            </div>
            <div class="form-check col">
              <input class="form-check-input" type="radio" name="incluyeGarantia" id="noG" value="false">
              <label class="form-check-label" for="noG">No</label>
            </div>
            <div class="form-group col">
                <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">$</div>
                    </div>
                    <input type="number" min="0" class="form-control" id="garantia" name="garantia" placeholder="¿Cuanto es?">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label>¿Se podrá modificar la renta?</label>
            </div>
            <div class="form-check col">
              <input class="form-check-input" type="radio" name="modificarRenta" id="siR" value="true">
              <label class="form-check-label" for="siR">Si</label>
            </div>
            <div class="form-check col">
              <input class="form-check-input" type="radio" name="modificarRenta" id="noR" value="false" checked>
              <label class="form-check-label" for="noR">No</label>
            </div>
            <div class="form-group col">
                <label for="periodicidad">Periodicidad</label>
                <select class="form-control" id="periodicidad" name="periodicidad">
                    <option value="1">Anual</option>
                    <option value="2">Semestral</option>
                </select>
            </div>
        </div>
        @if ($anuncio->inmueble->idTipoInmueble != 3)
        <div class="row">
            <div class="col">
                <label>¿Permite subarrendar?</label>
            </div>
            <div class="form-check col">
              <input class="form-check-input" type="radio" name="subarrendar" id="siS" value="true">
              <label class="form-check-label" for="siS">Si</label>
            </div>
            <div class="form-check col">
              <input class="form-check-input" type="radio" name="subarrendar" id="noS" value="false">
              <label class="form-check-label" for="noS">No</label>
            </div>
        </div>
        @endif
        <button type="submit" class="btn btn-primary">Aceptar</button>
        <a href="/inmueble/catalogo" class="btn btn-primary">Cancelar</a>
    </form>
</div>
@endsection