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
                                <a href="#" class="btn btn-primary" onclick="filtrar()">Filtrar</a>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="#" class="btn btn-danger" onclick="limpiarFiltros()">Limpiar</a>
                            </div>
                        </div>
                        <br>
                        <!--tipo-->
                        <div class="form-group row">
                            <label for="tipo" class="col-md-3 col-form-label text-md-right">{{ __('Tipo') }}</label>
                            <div class="col-md-9">
                                <select class="form-control" id="tipo" name="tipo" required>
                                    <option value="0" selected>...</option>
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
                                <select class="form-control" id="region" name="region" onchange="seleccionarRegion()" required>
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
                                <select class="form-control" id="provincia" name="provincia" onchange="seleccionarProvincia()" required>
                                </select>
                            </div>
                        </div>
                        <!--comuna-->
                        <div class="form-group row">
                            <label for="comuna" class="col-md-3 col-form-label text-md-right">{{ __('Comuna') }}</label>
                            <div class="col-md-9">
                                <select class="form-control" id="comuna" name="comuna" required>
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
                <div id="anuncios" class="row row-cols-1 row-cols-md-3 bg-secondary">
                    @foreach ($anuncios as $anuncio)
                    @if ($anuncio->estado)
                        <div class="col mb-3">
                            <div class="card" style="width: 16.8rem;">
                                <div class="card-body">
                                  <h5 class="card-title">{{ __( $anuncio->inmueble->calleDireccion.' '.$anuncio->inmueble->numeroDireccion ) }}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">{{ __( '$'.$anuncio->canon ) }}</h6>
                                  <p class="card-text">{{ __( $anuncio->condicionesArriendo ) }}</p>
                                  <p class="card-text">{{ __( $anuncio->documentosRequeridos ) }}</p>
                                    <p>{{ $anuncio->inmueble->comuna->provincia->region->nombre }}</p>
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

@section('scripts')
    <script type="text/javascript">

    function cargarAnuncios(anuncios) {
        var row = $("#anuncios");
        row.empty();
        anuncios.map(anuncio => {
            var col = $('<div></div>').addClass('col mb-3');
            var card = $('<div></div>').addClass('card');
            card.css('width: 16.8rem;');
            var card_body = $('<div></div>').addClass('card-body');
            var card_title = $('<h5>' + anuncio.idInmueble + '</h5>').addClass('card-title');
            var card_subtitle = $('<h6>$' + anuncio.canon + '</h6>').addClass('card-subtitle mb-2 text-muted');
            var card_text1 = $('<p>' + anuncio.condicionesArriendo + '</p>').addClass('card-text');
            var card_text2 = $('<p>' + anuncio.documentosRequeridos + '</p>').addClass('card-text');
            var p = $('<p>' + anuncio.idInmueble + '</p>');
            var card_link = $('<a href="/anuncio/' + anuncio.idInmueble + '">Ver más...</a>').addClass('card-link');
            card_body.append(card_title, card_subtitle, card_text1, card_text2, p, card_link);
            card.append(card_body);
            col.append(card);
            row.append(col);
        });
    }

    function limpiarFiltros() {
        $('#tipo').val(0);
        $('#region').val(0);
        $('#provincia').empty();
        $('#comuna').empty();
        $('#min').val(0);
        $('#max').val(0);
        $('#max').val(0);
        var fecha = $("input:radio[name=fecha]:checked");
        if(fecha[0]){
            fecha[0].checked = false;
        }
        $.ajax({
            url: '/catalogo/filtrar',
            type: "Get",
            dataType: 'json',//this will expect a json response
            data: {}, 
            success: function(response) {
                cargarAnuncios(response);
            }
        });
    }

    function filtrar() {

        var tipo = $('#tipo').val();
        tipo = tipo ? parseInt(tipo) : 0;

        var region = $('#region').val();
        region = region ? parseInt(region) : 0;
        var provincia = $('#provincia').val();
        provincia = provincia ? parseInt(provincia) : 0;
        var comuna = $('#comuna').val();
        comuna = comuna ? parseInt(comuna) : 0;

        var min = parseInt($('#min').val());
        var max = parseInt($('#max').val());
        if(max > 0 && min > max) {
            $('#min').val(max);
            $('#max').val(min);
            var temp = min;
            min = max;
            max = temp;
        }

        var fecha = $('input:radio[name=fecha]:checked').val();
        fecha = fecha ? parseInt(fecha) : 0;
        
        if(tipo > 0 || region > 0 || provincia > 0 || comuna > 0 || min > 0 || max > 0 || fecha > 0){
            $.ajax({
                url: '/catalogo/filtrar',
                type: "Get",
                dataType: 'json',//this will expect a json response
                data: {
                    tipo,
                    region,
                    provincia,
                    comuna,
                    min,
                    max,
                    fecha
                }, 
                success: function(response) {
                    cargarAnuncios(response);
                }
            });
        }
    }

    function seleccionarRegion() {
        var region = $('#region').val();
        if(region && region > 0) {
            $.ajax({
                url: '/provincias',
                type: "Get",
                dataType: 'json',//this will expect a json response
                data: {
                    id: $('#region').val()
                }, 
                success: function(response) {
                    $('#provincia').empty();
                    $('#provincia').append($('<option>', { 
                        value: 0,
                        text : '...'
                    }));
                    response.map(function(provincia) {
                        $('#provincia').append($('<option>', { 
                            value: provincia.id,
                            text : provincia.nombre
                        }));
                    });
                }
            });
        } else {
            $('#provincia').empty();
            $('#comuna').empty();
        }
    }

    function seleccionarProvincia() {
        var provincia = $('#provincia').val();
        if(provincia && provincia > 0) {
            $.ajax({
                url: '/comunas',
                type: "Get",
                dataType: 'json',//this will expect a json response
                data: {
                    id: $('#provincia').val()
                }, 
                success: function(response) {
                    $('#comuna').empty();
                    $('#comuna').append($('<option>', { 
                        value: 0,
                        text : '...'
                    }));
                    response.map(function(comuna) {
                        $('#comuna').append($('<option>', { 
                            value: comuna.id,
                            text : comuna.nombre
                        }));
                    });
                }
            });
        } else {
            $('#comuna').empty();
        }
    }

    </script>
@endsection