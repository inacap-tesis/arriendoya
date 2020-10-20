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
                        Aquí va la lista de anuncios
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection