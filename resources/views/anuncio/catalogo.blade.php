@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3 bg-dark text-white">
                <br>
                <div class="row text-center">
                    <div class="col">
                        <a href="/inmueble/catalogo" class="btn btn-primary">{{ __($inmuebles > 0 ? 'Mis Inmuebles' : 'Publicar Anuncio') }}</a>
                        @if ($arriendos > 0)
                        <a href="/arriendo/catalogo" class="btn btn-primary">{{ __('Mis Arriendos') }}</a>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Filtros</h5>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="#" class="btn btn-danger">Limpiar</a>
                            </div>
                        </div>
                        <br>
                        <!--tipo-->
                        <div class="form-group row">
                            <label for="tipo" class="col-md-3 col-form-label text-md-right">{{ __('Tipo') }}</label>
                            <div class="col-md-9">
                                <select class="form-control" id="tipo" name="tipo" required>
                                    @foreach ($tipos as $tipo)
                                    <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <hr class="bg-white">
                        <!--region-->
                        <div class="form-group row">
                            <label for="region" class="col-md-3 col-form-label text-md-right">{{ __('Región') }}</label>
                            <div class="col-md-9">
                                <select class="form-control" id="region" name="region" required>
                                    <option value="0" selected>...</option>
                                    @foreach ($regiones as $region)
                                    <option value="{{$region->id}}">{{$region->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!--provincia-->
                        <div class="form-group row">
                            <label for="provincia" class="col-md-3 col-form-label text-md-right">{{ __('Provincia') }}</label>
                            <div class="col-md-9">
                                <select class="form-control" id="provincia" name="provincia" required>
                                    <option value="0" selected>...</option>
                                    @foreach ($provincias as $provincia)
                                    <option value="{{$provincia->id}}">{{$provincia->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!--comuna-->
                        <div class="form-group row">
                            <label for="comuna" class="col-md-3 col-form-label text-md-right">{{ __('Comuna') }}</label>
                            <div class="col-md-9">
                                <select class="form-control" id="comuna" name="comuna" required>
                                    <option value="0" selected>...</option>
                                    @foreach ($comunas as $comuna)
                                    <option value="{{$comuna->id}}">{{$comuna->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <hr class="bg-white">
                        <!--min-->
                        <div class="form-group row">
                            <label for="min" class="col-md-3 col-form-label text-md-right">{{ __('Mínimo') }}</label>
                            <div class="col-md-9">
                                <select class="form-control" id="min" name="min" required>
                                    <option value="0" selected>Precio mínimo</option>
                                    @foreach ($precios as $id => $nombre)
                                    <option value="{{$id}}">{{$nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!--max-->
                        <div class="form-group row">
                            <label for="max" class="col-md-3 col-form-label text-md-right">{{ __('Máximo') }}</label>
                            <div class="col-md-9">
                                <select class="form-control" id="max" name="max" required>
                                    <option value="0" selected>Precio máximo</option>
                                    @foreach ($precios as $id => $nombre)
                                    <option value="{{$id}}">{{$nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <hr class="bg-white">
                        <!--fecha-->
                        <div class="form-group row">
                            <label for="fecha" class="col-md-3 col-form-label text-md-right">{{ __('Publicado') }}</label>
                            <div class="col-md-9">
                                <ul class="list-group list-group-flush text-dark">
                                    @foreach ($fechas as $id => $nombre)
                                    <li class="list-group-item">
                                        <div class="form-check">
                                          <input class="form-check-input" type="radio" name="fecha" value="{{$id}}" id="{{ 'fecha_'.$id }}">
                                          <label class="form-check-label" for="{{ 'fecha_'.$id }}">{{ __($nombre) }}</label>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-9">
                <div class="row bg-white">
                    <div class="col-4">Ordenar</div>
                    <div class="col-4">
                        <a href="#" class="btn btn-primary">Precio</a>
                    </div>
                    <div class="col-4">
                        <a href="#" class="btn btn-primary">Fecha</a>
                    </div>
                </div>
                <div class="row row-cols-1 row-cols-md-3 bg-secondary">
                    @foreach ($anuncios as $anuncio)
                    @if ($anuncio->estado)
                        <div class="col mb-3">
                            <div class="card" style="width: 16.8rem;">
                                <div class="card-body">
                                  <h5 class="card-title">{{ __( $anuncio->inmueble->calleDireccion.' '.$anuncio->inmueble->numeroDireccion ) }}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">{{ __( '$'.$anuncio->canon ) }}</h6>
                                  <p class="card-text">{{ __( $anuncio->condicionesArriendo ) }}</p>
                                  <p class="card-text">{{ __( $anuncio->documentosRequeridos ) }}</p>
                                  <a href="{{ '/anuncio'.'/'.$anuncio->idInmueble }}" class="card-link">Ver más...</a>
                                </div>
                            </div>
                        </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection