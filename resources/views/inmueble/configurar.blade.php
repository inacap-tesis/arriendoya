@extends('layouts.app')

@section('content')
<div class="container" style="margin-top:20px">
    @if ($inmueble)
    <h3>Modificar Inmueble</h3>
    <form action="/inmueble" method="post" enctype="multipart/form-data">
        @method('PUT')
        <input type="hidden" name="id" value="{{$inmueble->id}}">
    @else
    <h3>Registrar Inmueble</h3>
    <form action="/inmueble" method="POST" enctype="multipart/form-data">
    @endif
        @csrf
        <div class="row">
            <div class="col-8">
                <div class="form-group">
                    <label for="tipo">Tipo de Inmueble</label>
                    @foreach ($tipos_inmueble as $tipo_inmueble)
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="tipo" id="radio_{{$tipo_inmueble->id}}" value="{{$tipo_inmueble->id}}" @if ($inmueble && $inmueble->idTipoInmueble == $tipo_inmueble->id) checked @endif required>
                        <label class="form-check-label" for="radio_{{$tipo_inmueble->id}}">{{$tipo_inmueble->nombre}}</label>
                    </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <label for="region">Región</label>
                    <select class="form-control" id="region" name="region" onchange="seleccionarRegion()" required>
                        <option value="0" @if (!$inmueble) selected @endif>...</option>
                        @foreach ($regiones as $region)
                        <option value="{{$region->id}}" @if ($inmueble && $region->id == $inmueble->comuna->provincia->idRegion) selected @endif>{{$region->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="provincia">Provincia</label>
                    <select class="form-control" id="provincia" name="provincia" onchange="seleccionarProvincia()" required>
                        @if ($inmueble)
                        <option value="0">...</option>
                        @foreach ($provincias as $provincia)
                        <option value="{{$provincia->id}}" @if ($provincia->id == $inmueble->comuna->idProvincia) selected @endif>{{$provincia->nombre}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label for="comuna">Comuna</label>
                    <select class="form-control" id="comuna" name="comuna" required>
                        @if ($inmueble)
                        <option value="0">...</option>
                        @foreach ($comunas as $comuna)
                        <option value="{{$comuna->id}}" @if ($comuna->id == $inmueble->idComuna) selected @endif>{{$comuna->nombre}}</option>
                        @endforeach
                        @endif
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
                @if ($inmueble)
                @php $position = 0; @endphp
                @foreach ($inmueble->fotos as $foto)
                @php $position = $loop->index + 1; @endphp
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="{{ __('fotoInfo'.$position) }}">{{ $position }}</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" onchange="cambiaFoto({{ $position }})" class="custom-file-input" id="{{ __('foto'.$position) }}" name="{{ __('foto'.$position) }}" aria-describedby="{{ __('fotoInfo'.$position) }}">
                        <label id="{{ __('foto'.$position.'Str') }}" class="custom-file-label" for="{{ __('foto'.$position) }}">{{ __('Foto '.$position) }}</label>
                        <input type="hidden" id="{{ __('_'.$position) }}" name="{{ __('_'.$position) }}" value="0">
                    </div>
                </div>
                @endforeach
                @for ($i = ($position + 1); $i <= 5; $i++)
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="{{ __('fotoInfo'.$i) }}">{{ $i }}</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" onchange="cambiaFoto({{ $i }})" class="custom-file-input" id="{{ __('foto'.$i) }}" name="{{ __('foto'.$i) }}" aria-describedby="{{ __('fotoInfo'.$i) }}">
                        <label id="{{ __('foto'.$i.'Str') }}" class="custom-file-label" for="{{ __('foto'.$i) }}">Buscar</label>
                    </div>
                </div>
                @endfor
                @else
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="fotoInfo1">1</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" onchange="cambiaFoto(1)" class="custom-file-input" id="foto1" name="foto1" aria-describedby="fotoInfo1">
                        <label id="foto1Str" class="custom-file-label" for="foto1">Buscar</label>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="fotoInfo2">2</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" onchange="cambiaFoto(2)" class="custom-file-input" id="foto2" name="foto2" aria-describedby="fotoInfo2">
                        <label id="foto2Str" class="custom-file-label" for="foto2">Buscar</label>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="fotoInfo3">3</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" onchange="cambiaFoto(3)" class="custom-file-input" id="foto3" name="foto3" aria-describedby="fotoInfo3">
                        <label id="foto3Str" class="custom-file-label" for="foto3">Buscar</label>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="fotoInfo4">4</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" onchange="cambiaFoto(4)" class="custom-file-input" id="foto4" name="foto4" aria-describedby="fotoInfo4">
                        <label id="foto4Str" class="custom-file-label" for="foto4">Buscar</label>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="fotoInfo5">5</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" onchange="cambiaFoto(5)" class="custom-file-input" id="foto5" name="foto5" aria-describedby="fotoInfo5">
                        <label id="foto5Str" class="custom-file-label" for="foto5">Buscar</label>
                    </div>
                </div>
                @endif
            </div>
        </div>   
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="/inmuebles" class="btn btn-primary">Cancelar</a>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/location.js') }}" defer></script>
<script type="text/javascript">
    function cambiaFoto(id) {
        if($('#_' + id).val()) {
            $('#_' + id).val(1);
        }
        file = $("#foto" + id)[0].files[0];
        $('#foto' + id + 'Str').text(file ? file.name : 'Buscar');
    }
</script>
@endsection