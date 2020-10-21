@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3 bg-dark text-white">
                <div class="row">
                    <div class="col">
                        Aquí van las opciones para filtrar anuncios
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <a href="/inmueble/catalogo" class="btn btn-primary">Publicar Anuncio</a>
                    </div>
                </div>
            </div>
            <div class="col-9 text-white">
                <div class="row bg-secondary">
                    <div class="col">
                        Aquí van las opciones para ordenar anuncios
                    </div>
                </div>
                <div class="row bg-primary">
                    <div class="col">
                        @foreach ($anuncios as $anuncio)
                        @if ($anuncio->estado)
                            <div class="card" style="width: 18rem;">
                                <div class="card-body">
                                  <h5 class="card-title">{{ __( $anuncio->idInmueble ) }}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">{{ __( '$'.$anuncio->canon ) }}</h6>
                                  <p class="card-text">{{ __( $anuncio->condicionesArriendo ) }}</p>
                                  <p class="card-text">{{ __( $anuncio->documentosRequeridos ) }}</p>
                                  <a href="#" class="card-link">Card link</a>
                                  <a href="#" class="card-link">Another link</a>
                                </div>
                            </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection