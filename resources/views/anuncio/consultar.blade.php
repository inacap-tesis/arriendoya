@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h4>
                {{ $anuncio->inmueble->tipo->nombre.' en '.$anuncio->inmueble->calleDireccion.' '.$anuncio->inmueble->numeroDireccion.' - '.$anuncio->inmueble->comuna->nombre }}
            </h4>
            <br>
        </div>
        <div class="col text-right">
          <form action="/interes" method="POST">
            <input type="hidden" name="id" value="{{ $anuncio->idInmueble }}">
            @csrf
            @if (count($interes) > 0)
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Quitar interes</button>
            @else
            <button type="submit" class="btn btn-primary">Estoy interesado</button>
            @endif
          </form>
        </div>
    </div>
    <div class="row">
        <div class="col-5">
            <h5>Canon:</h5>
            <p>{{ '$ '.number_format($anuncio->canon, 0, ',', '.') }}</p>
            <hr>
            <h5>Características:</h5>
            <p>
                {{ $anuncio->inmueble->caracteristicas }}
            </p>
            <hr>
            <h5>Condiciones del arriendo:</h5>
            <p>
                {{ $anuncio->condicionesArriendo }}
            </p>
            <hr>
            <h5>Documentos requeridos:</h5>
            <p>
                {{ $anuncio->documentosRequeridos }}
            </p>
        </div>
        <div class="col-7">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                  @if (count($anuncio->inmueble->fotos) > 0)
                  @for ($i = 0; $i < count($anuncio->inmueble->fotos); $i++)
                  <li data-target="#carouselExampleIndicators" data-slide-to="{{ $i }}" @if($i == 0) class="active" @endif></li>
                  @endfor
                  @else
                  <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                  @endif
                </ol>
                <div class="carousel-inner">
                  @if (count($anuncio->inmueble->fotos) > 0)
                  @php $primero = true; @endphp
                  @foreach ($anuncio->inmueble->fotos as $foto)
                  <div class="carousel-item @if($primero) active @endif">
                    <img src="{{ asset('storage/'.$foto->urlFoto) }}" class="d-block w-100 rounded" alt="...">
                  </div>
                  @php $primero = false; @endphp
                  @endforeach
                  @else
                  <div class="carousel-item active">
                    <img src="{{ asset('images/inmueble_default.png') }}" class="d-block w-100" alt="...">
                  </div>
                  @endif
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6"></div>
        <div class="col-6"></div>
    </div>
</div>
@endsection