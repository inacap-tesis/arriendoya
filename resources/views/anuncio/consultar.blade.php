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
            @if (count($interes) > 0)
            <a href="{{ '/anuncio/desinteres/'.$anuncio->idInmueble }}" class="btn btn-danger">Quitar interes</a>
            @else
            <a href="{{ '/anuncio/interes/'.$anuncio->idInmueble }}" class="btn btn-success">Estoy interesado</a>
            @endif
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
                  <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                  <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                  <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="https://www.hogares.cl/wp-content/uploads/2018/06/SLA_3734.jpg" class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="https://i.pinimg.com/originals/04/2d/73/042d736ae635b16c71172d771ea11545.jpg" class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="https://blog.ibaquedano.cl/wp-content/uploads/2019/04/Qu%C3%A9-tipo-de-departamento-necesito.jpg" class="d-block w-100" alt="...">
                  </div>
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