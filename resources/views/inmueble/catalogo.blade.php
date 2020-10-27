@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top:20px">
        <div class="row">
            <h3 class="col-10">Mis Inmuebles</h3>
            <a href="/inmueble/registrar" class="col-2 btn btn-primary">Agregar</a>
        </div>
        <div class="row row-cols-1 row-cols-md-3">
          @foreach ($inmuebles as $inmueble)
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
                      array('Modificar', '/inmueble/modificar'),
                      array('Dar de baja', '/inmueble/baja'),
                      array('Publicar', '/inmueble/publicar')
                    ]
                @endphp
                  @break
              @case(2)
                @php
                    $color = 'primary';
                    $botones = [
                      array('Modificar Inmueble', '/inmueble/modificar'),
                      array('Modificar Publicación', '/inmueble/publicar'),
                      array('Quitar publicación', '/inmueble/anuncio'),
                      array('Ver interesados', '/anuncio/interesados')
                    ]
                @endphp
                  @break
              @case(3)
                  @php
                    $color = 'danger';
                    $botones = [
                      array('Reactivar', '/inmueble/alta'),
                      array('Eliminar', '/inmueble/eliminar')
                    ]
                @endphp
                  @break
              @case(4)
                  @php
                    $color = 'warning';
                    $botones = [
                      array('Modificar', '/inmueble/modificar'),
                      array('Quitar publicación', '/inmueble/anuncio'),
                      array('Ver interesados', '/anuncio/interesados'),
                      array('No arrendar', '#'),
                      array('Obtener contrato', '/inmueble/contrato'),
                      array('Iniciar arriendo', '#')
                    ]
                @endphp
                  @break
              @case(5)
                @php
                    $color = 'success';
                    $botones = [
                      array('Ver arriendo', '#'),
                    ]
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
            'caracteristicas' => $inmueble->caracteristicas,
            'color' => $color,
            'botones' => $botones,
            'tipo' => $tipo,
            'id' => $inmueble->id
            ])
          @endforeach
        </div>
    </div>
@endsection