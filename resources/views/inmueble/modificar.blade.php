@extends('layouts.app')

@section('content')
<div class="container" style="margin-top:20px">
    @if ($inmueble)
    <h3>Modificar Inmueble</h3>
    <form action="/inmueble/modificar" method="post">
        @method('PUT')
        <input type="hidden" name="id" value="{{$inmueble->id}}">
    @else
    <h3>Registrar Inmueble</h3>
    <form action="/inmueble/registrar" method="POST">
    @endif
        @csrf
        <div class="row">
            <div class="col-8">
                <div class="form-group">
                    <label for="tipo">Tipo de Inmueble</label>
                    @foreach ($tipos_inmueble as $tipo_inmueble)
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="tipo" id="radio_{{$tipo_inmueble->id}}" value="{{$tipo_inmueble->id}}" @if ($inmueble->idTipoInmueble == $tipo_inmueble->id) checked @endif required>
                        <label class="form-check-label" for="radio_{{$tipo_inmueble->id}}">{{$tipo_inmueble->nombre}}</label>
                    </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <label for="region">Región</label>
                    <select class="form-control" id="region" name="region" required>
                        @foreach ($regiones as $region)
                        <option value="{{$region->id}}">{{$region->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="provincia">Provincia</label>
                    <select class="form-control" id="provincia" name="provincia" required>
                        @foreach ($provincias as $provincia)
                        <option value="{{$provincia->id}}">{{$provincia->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="comuna">Comuna</label>
                    <select class="form-control" id="comuna" name="comuna" required>
                        @foreach ($comunas as $comuna)
                        <option value="{{$comuna->id}}" @if ($inmueble->idComuna == $comuna->id) selected @endif>{{$comuna->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="poblacionDireccion">Población</label>
                <input type="text" class="form-control" id="poblacionDireccion" name="poblacionDireccion" @if ($inmueble) value="{{$inmueble->poblacionDireccion}}" @endif >
                </div>
                <div class="form-group">
                    <label for="calleDireccion">Calle</label>
                    <input type="text" class="form-control" id="calleDireccion" name="calleDireccion" required @if ($inmueble) value="{{$inmueble->calleDireccion}}" @endif>
                </div>
                <div class="form-group">
                    <label for="numeroDireccion">Número</label>
                    <input type="number" min="0" class="form-control" id="numeroDireccion" name="numeroDireccion" required @if ($inmueble) value="{{$inmueble->numeroDireccion}}" @endif>
                </div>
                <div class="form-group">
                    <label for="condominioDireccion">Condominio</label>
                    <input type="text" class="form-control" id="condominioDireccion" name="condominioDireccion" @if ($inmueble) value="{{$inmueble->condominioDireccion}}" @endif>
                </div>
                <div class="form-group">
                    <label for="numeroDepartamentoDireccion">Número de departamento/casa</label>
                    <input type="text" class="form-control" id="numeroDepartamentoDireccion" name="numeroDepartamentoDireccion" @if ($inmueble) value="{{$inmueble->numeroDepartamentoDireccion}}" @endif>
                </div>
                <div class="form-group">
                    <label for="caracteristicas">Características</label>
                    <textarea class="form-control is-invalid" id="caracteristicas" name="caracteristicas" rows="3" required>@if ($inmueble){{ $inmueble->caracteristicas }}@endif</textarea>
                    <div class="invalid-feedback">
                        Por favor ingrese las características del inmueble.
                    </div>
                </div>
            </div>
            <div class="col-4">
                <h4 class="text-center">Fotos</h4>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="fotoInfo1">1</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="foto1" name="foto1" aria-describedby="fotoInfo1">
                        <label class="custom-file-label" for="foto1">Buscar</label>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="fotoInfo2">2</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="foto2" name="foto2" aria-describedby="fotoInfo2">
                        <label class="custom-file-label" for="foto2">Buscar</label>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="fotoInfo3">3</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="foto3" name="foto3" aria-describedby="fotoInfo3">
                        <label class="custom-file-label" for="foto3">Buscar</label>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="fotoInfo4">4</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="foto4" name="foto4" aria-describedby="fotoInfo4">
                        <label class="custom-file-label" for="foto4">Buscar</label>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="fotoInfo5">5</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="foto5" name="foto5" aria-describedby="fotoInfo5">
                        <label class="custom-file-label" for="foto5">Buscar</label>
                    </div>
                </div>
            </div>
        </div>   
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="/inmueble/catalogo" class="btn btn-primary">Cancelar</a>
    </form>
</div>
@endsection