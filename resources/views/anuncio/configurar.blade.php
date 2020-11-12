@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                @switch($inmueble->idTipoInmueble)
                    @case(1)
                        @php $tipo = 'Casa'; @endphp
                        @break
                    @case(2)
                      @php $tipo = 'Departamento'; @endphp
                        @break
                    @case(3)
                      @php $tipo = 'Habitación'; @endphp  
                        @break
                    @default
                      @php $tipo = ''; @endphp  
                @endswitch
                <div class="card-header" style="font-weight: bold;">
                    {{ __('Configurar anuncio de ( '. $tipo.' en '.$inmueble->calleDireccion.' '.$inmueble->numeroDireccion.' )' ) }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('publicar') }}">
                        @csrf

                        <input type="hidden" name="id" value="{{$inmueble->id}}">

                        <!--canon-->
                        <div class="form-group row">
                            <label for="canon" class="col-md-4 col-form-label text-md-right">{{ __('Renta mensual') }}</label>
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                      <div class="input-group-text">$</div>
                                    </div>
                                    <input type="number" min="0" class="form-control" id="canon" name="canon" @if ($inmueble->anuncio) value="{{ $inmueble->anuncio->canon }}" @endif required>
                                </div>
                            </div>
                        </div>

                        <!--condicionesArriendo-->
                        <div class="form-group row">
                            <label for="condicionesArriendo" class="col-md-4 col-form-label text-md-right">{{ __('Condiciones del arriendo') }}</label>
                            <div class="col-md-6">
                                <textarea class="form-control" id="condicionesArriendo" name="condicionesArriendo" rows="3" placeholder="¿Cuales son las principales condiciones que tendrá el arriendo de este inmueble?" required>@if ($inmueble->anuncio){{ $inmueble->anuncio->condicionesArriendo }}@endif</textarea>
                            </div>
                        </div>

                        <!--documentosRequeridos-->
                        <div class="form-group row">
                            <label for="documentosRequeridos" class="col-md-4 col-form-label text-md-right">{{ __('Documentos requeridos') }}</label>
                            <div class="col-md-6">
                                <textarea class="form-control" id="documentosRequeridos" name="documentosRequeridos" rows="3" placeholder="¿Qué documentos necesitarás de los interesados en este anuncio?" required>@if ($inmueble->anuncio){{ $inmueble->anuncio->documentosRequeridos }}@endif</textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Publicar</button>
                        <a href="/inmuebles" class="btn btn-primary">Cancelar</a>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection