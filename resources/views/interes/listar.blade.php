@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-header" style="font-weight: bold;">{{ __('Interesados en '.$anuncio->inmueble->tipo->nombre.' que está en '.$anuncio->inmueble->calleDireccion.' '.$anuncio->inmueble->numeroDireccion) }}</div>
        <div class="card-body">
          <form action="/interes/candidatos" method="POST">
            @csrf
            @method('POST')
            <input type="hidden" value="{{ $anuncio->idInmueble }}" name="anuncio">
            <div class="container">
              <div class="row">
                <div class="col">
                  <h3>Lista de Interesados</h3>
                </div>
                <div class="col text-right">
                  <button type="submit" class="btn btn-success">
                    <svg class="bi" width="20" height="20" fill="currentColor">
                      <use xlink:href="{{ asset('icons/bootstrap-icons.svg').'#check' }}"/>
                    </svg>
                  </button>
                  <a href="/inmuebles" class="btn btn-danger">
                    <svg class="bi" width="20" height="20" fill="currentColor">
                      <use xlink:href="{{ asset('icons/bootstrap-icons.svg').'#x' }}"/>
                    </svg>
                  </a>
                </div>
              </div>
              @include('layouts.modal', [
                'static' => false,
                'size' => 'modal-lg'
                ])
              <br>
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Interesado</th>
                      <th scope="col" class="text-center">¿Es candidato?</th>
                      <th scope="col" class="text-right"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($intereses as $interes)
                    <tr id="{{ $interes->usuario->rut }}">
                      <th scope="row">
                        {{ __($interes->usuario->primerNombre.' '.$interes->usuario->segundoNombre.' '.$interes->usuario->primerApellido.' '.$interes->usuario->segundoApellido) }}
                      </th>
                      <td class="text-center">
                        <input style="width:20px; height:20px;" class="form-check-input" type="checkbox" name="{{ $interes->usuario->rut }}" id="{{ $interes->usuario->rut }}" @if ($interes->candidato) checked @endif>
                      </td>
                      <td class="text-right">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" onclick="mostrarCalificaciones({{ $interes->usuario }})">
                          Calificaciones
                          <svg class="bi" width="20" height="20" fill="currentColor">
                            <use xlink:href="{{ asset('icons/bootstrap-icons.svg').'#bookmark-star-fill' }}"/>
                          </svg>
                        </button>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" onclick="mostrarAntecedentes({{ $interes->usuario }})">
                          Antecedentes
                          <svg class="bi" width="20" height="20" fill="currentColor">
                            <use xlink:href="{{ asset('icons/bootstrap-icons.svg').'#file-earmark-text-fill' }}"/>
                          </svg>
                        </button>
                        <a href="#" class="btn btn-danger" onclick="{{ __('eliminarInteres('.$anuncio->idInmueble.',"'.$interes->usuario->rut.'")') }}">
                          Eliminar
                          <svg class="bi" width="20" height="20" fill="currentColor">
                            <use xlink:href="{{ asset('icons/bootstrap-icons.svg').'#trash-fill' }}"/>
                          </svg>
                        </a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    function eliminarInteres(anuncio, usuario) {
      $.ajax({
          url: '/interes',
          type: "DELETE",
          dataType: 'json',//this will expect a json response
          data: {
            '_token': '{{ csrf_token() }}',
            anuncio,
            usuario
          }, 
          success: function(response) {
            $('#' + response.rutUsuario).remove();
          }
      });
    }

    function mostrarAntecedentes(usuario) {
      nombre = usuario.primerNombre + ' ' + usuario.segundoNombre + ' ' + usuario.primerApellido + ' ' + usuario.segundoApellido;
      $('#titleModal').text('Antecedentes de ' + nombre);
      $.ajax({
          url: '/antecedentes/' + usuario.rut,
          type: "GET",
          dataType: 'json',//this will expect a json response
          data: {}, 
          success: function(response) {
            var ul = $('<ul></ul>');
            response.map(obj => {
              var a = $('<a href="/antecedente/' + obj.id + '">' + obj.titulo + '</a>');
              var li = $('<li></li>');
              li.append(a);
              ul.append(li);
            });
            $('#bodyModal').empty();
            $('#bodyModal').append(ul);
            $('#ventanaModal').modal('toggle');
          }
      });
    }

    function mostrarCalificaciones(usuario) {
      nombre = usuario.primerNombre + ' ' + usuario.segundoNombre + ' ' + usuario.primerApellido + ' ' + usuario.segundoApellido;
      $('#titleModal').text('Calificaciones de ' + nombre);
      $.ajax({
          url: '/calificaciones/' + usuario.rut,
          type: "GET",
          dataType: 'json',//this will expect a json response
          data: {}, 
          success: function(response) {
            var accordion = $('<div class="accordion" id="calificaciones"></div>');
            var primero = true;
            response.map(calificacion => {
              var propietario = calificacion.arriendo.inmueble.propietario;
              var nota = calificacion.notaAlInquilino;
              var comentario = calificacion.comentarioAlInquilino;
              var notaSistema = calificacion.cumplimientoInquilino;

              var card = $('<div class="card"></div>');
              var header = $('<div class="card-header" id="__' + calificacion.idArriendo + '"></div>');
              var titulo = $('<h2 class="mb-0"></h2>');
              var btn = $('<button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#_' + calificacion.idArriendo + '" aria-expanded="true" aria-controls="_' + calificacion.idArriendo + '"></button>');
              var nombre = propietario.primerNombre + ' ' + propietario.primerApellido;
              var url = '{{ asset("") }}' + 'storage/' + propietario.urlFoto;
              var foto = $('<img src="' + url + '" alt="" height="45" class="rounded-circle" style="margin: 0px 10px 0px 0px">');
              var row = $('<div class="row"></div>');
              var col1 = $('<div class="col"></div>');
              col1.append(foto, nombre);
              var subRow = $('<div style="margin-top: 6px;" class="row justify-content-end"></div>');
              var divNotaSistema = $('<div class="btn text-white bg-' + (notaSistema < 3 ? 'danger' : 'success') + '"><b>' + notaSistema + '</b>  <span class="badge badge-secondary">Cumplimiento</span></div>');
              if(nota > 0) {
                var divNotaPropietario = $('<div style="margin-right: 5px;" class="btn text-white bg-' + (nota < 3 ? 'danger' : 'success') + '"><b>' + nota + '</b>  <span class="badge badge-secondary">Conformidad</span></div>');
                subRow.append(divNotaPropietario, divNotaSistema);
              } else {
                subRow.append(divNotaSistema);
              }
              var col2 = $('<div class="col text-right"></div>');
              col2.append(subRow);
              row.append(col1, col2);
              btn.append(row);
              titulo.append(btn);
              header.append(titulo);
              if(primero) {
                var collapse = $('<div id="_' + calificacion.idArriendo + '" class="collapse show" aria-labelledby="__' + calificacion.idArriendo + '" data-parent="#calificaciones"></div>');
                primero = false;
              } else {
                var collapse = $('<div id="_' + calificacion.idArriendo + '" class="collapse" aria-labelledby="__' + calificacion.idArriendo + '" data-parent="#calificaciones"></div>');
              }
              var contenido = $('<div class="card-body"></div>');
              contenido.append($('<i>" ' + comentario + ' "</i>'));
              collapse.append(contenido);
              card.append(header, collapse);
              accordion.append(card);
            });
            $('#bodyModal').empty();
            $('#bodyModal').append(accordion);
            $('#ventanaModal').modal('toggle');
          }
      });
    }
</script>
@endsection
