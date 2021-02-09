@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3 rounded-lg bg-dark text-white">
                <br>
                <div class="row text-center">
                    <div class="col">
                        @if ($inmuebles > 0)
                        <a href="/inmuebles" class="btn btn-primary">{{ __('Mis Inmuebles') }}</a>
                        @else
                        <a href="/inmueble" class="btn btn-primary">{{ __('Publicar Anuncio') }}</a>
                        @endif
                        @if ($arriendos > 0)
                        <a href="/arriendos" class="btn btn-primary">{{ __('Mis Arriendos') }}</a>
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
                <div class="row">
                    <div class="col text-right">
                        <a id="precio" class="text-secondary" onclick="ordenar('precio')" data-toggle="tooltip" data-placement="top" title="Mostrar lo más barato primero">
                            <svg class="bi" width="10" height="10" fill="currentColor">
                                <use xlink:href="{{ asset('icons/bootstrap-icons.svg').'#caret-down-fill' }}"/>
                            </svg>
                            <svg class="bi" width="30" height="30" fill="currentColor">
                                <use xlink:href="{{ asset('icons/bootstrap-icons.svg').'#cash' }}"/>
                            </svg>
                        </a>
                        <a id="fecha" class="text-secondary" onclick="ordenar('fecha')" data-toggle="tooltip" data-placement="top" title="Mostrar lo más reciente primero" style="display: none">
                            <svg class="bi" width="10" height="10" fill="currentColor">
                                <use xlink:href="{{ asset('icons/bootstrap-icons.svg').'#caret-down-fill' }}"/>
                            </svg>
                            <svg class="bi" width="25" height="25" fill="currentColor">
                                <use xlink:href="{{ asset('icons/bootstrap-icons.svg').'#calendar3' }}"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <div id="anuncios" class="row">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="{{ asset('js/location.js') }}" defer></script>
<script type="text/javascript">

    document.addEventListener('DOMContentLoaded', function () {
        $.ajax({
            url: '/catalogo/filtrar',
            type: "Get",
            dataType: 'json',//this will expect a json response
            data: {}, 
            success: function(response) {
                cargarAnuncios(response.view);
            }
        });
    });

    function cargarAnuncios(view) {
        var row = $("#anuncios");
        row.empty();
        row.html(view);
    }

    function capturarFiltros() {

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

        if(tipo > 0 || region > 0 || provincia > 0 || comuna > 0 || min > 0 || max > 0 || fecha > 0) {
            return { 
                tipo, 
                region, 
                provincia,
                comuna,
                min,
                max,
                fecha
            }
        } else {
            return null;
        }
    }

    function limpiarFiltros() {

        if(capturarFiltros()) {
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
                    cargarAnuncios(response.view);
                }
            });
        }

    }

    function filtrar(tipoOrden = null) {
        
        var filtros = capturarFiltros();
        
        if(filtros || tipoOrden) {

            $.ajax({
                url: '/catalogo/filtrar',
                type: "Get",
                dataType: 'json',//this will expect a json response
                data: filtros ? {
                    tipo: filtros.tipo,
                    region: filtros.region,
                    provincia: filtros.provincia,
                    comuna: filtros.comuna,
                    min: filtros.min,
                    max: filtros.max,
                    fecha: filtros.fecha,
                    tipoOrden: tipoOrden
                } : { tipoOrden: tipoOrden }, 
                success: function(response) {
                    cargarAnuncios(response.view);
                }
            });
        }
    }

    function ordenar(tipo) {
        if(tipo == 'precio') {
            $('#precio').css('display', 'none');
            $('#fecha').removeAttr('style');
        } else {
            $('#fecha').css('display', 'none');
            $('#precio').removeAttr('style');
        }
        filtrar(tipo);
    }

</script>
@endsection