@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top:20px">
        <div class="row">
            <h3 class="col">Mis Inmuebles</h3>
            <div class="col text-right">
              <a href="/inmueble" class="btn btn-success">
                Agregar
                <svg class="bi" width="20" height="20" fill="currentColor">
                  <use xlink:href="{{ asset('icons/bootstrap-icons.svg').'#plus' }}"/>
                </svg>
              </a>
            </div>
        </div>
        <br>
        <div class="row row-cols-1 row-cols-md-3">
          @foreach ($inmuebles as $inmueble)
          @php 
          $id = $inmueble->id;
          $esArriendo = false;
          @endphp
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
          @switch($inmueble->idEstado)
              @case(1)
                @php
                    $color = 'dark';
                    $botones = [
                      array('Modificar', '/inmueble'),
                      array('Dar de baja', '/inmueble/desactivar'),
                      array('Publicar', '/anuncio/configurar')
                    ]
                @endphp
                  @break
              @case(2)
                @php
                    $color = 'primary';
                    $botones = [
                      array('Modificar inmueble', '/inmueble'),
                      array('Modificar anuncio', '/anuncio/configurar'),
                      array('Quitar publicación', '/anuncio/desactivar'),
                      array('Ver interesados', '/interesados')
                    ]
                @endphp
                  @break
              @case(3)
                  @php
                    $color = 'danger';
                    $botones = [
                      array('Reactivar', '/inmueble/activar'),
                      array('Eliminar', '/inmueble')
                    ]
                @endphp
                  @break
              @case(4)
                  @php
                    $color = 'warning';
                    $botones = [
                      array('Modificar inmueble', '/inmueble'),
                      array('Quitar anuncio', '/anuncio/desactivar'),
                      array('Ver interesados', '/interesados'),
                      array('Configurar arriendo', '/arriendo/configurar'),
                      array('Obtener contrato', '/inmueble/contrato'),
                    ]
                @endphp
                  @break
              @case(5)
                @php
                    $color = 'warning';
                    $botones = [
                      array('Modificar ariendo', '/arriendo/configurar'),
                      array('No arrendar', '/arriendo'),
                      array('Obtener contrato', '/inmueble/contrato'),
                      array('Iniciar arriendo', '/arriendo/cargarContrato')
                    ]
                @endphp
                  @break
              @case(6)
                @php
                    $id = $inmueble->arriendos->first()->id;
                    $esArriendo = true;
                    $color = 'success';
                    $botones = [
                      array('Ver arriendo', '/arriendo')
                    ]
                @endphp
                  @break
              @case(7)
                  @php
                    $esArriendo = true;
                    $color = 'success';
                    $botones = [];
                    $arriendo = $inmueble->arriendos->first();
                    $id = $arriendo->id;
                    if($arriendo->garantia && !$arriendo->garantia->devolucion) {
                      array_push($botones, array('Devolver garantía', '/garantia/devolucion'));
                    }
                    if(!$arriendo->calificacion || $arriendo->calificacion->notaAlInquilino == 0) {
                      array_push($botones, array('Calificar inquilino', '/calificacion'));
                    }

                  @endphp
                    @break
              @default
                @php
                    $color = '';
                    $botones = [];
                @endphp  
          @endswitch
          @include('inmueble.item', [
            'direccion' => $inmueble->calleDireccion.' '.$inmueble->numeroDireccion,
            'elemento' => $esArriendo ? $inmueble->arriendos->first() : $inmueble,
            'esArriendo' => $esArriendo,
            'color' => $color,
            'botones' => $botones,
            'tipo' => $tipo,
            'id' => $id
            ])
          @endforeach
        </div>
    </div>
@endsection