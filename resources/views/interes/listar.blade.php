@extends('layouts.app')

@section('content')
<form action="/interes/candidatos" method="POST">
  @csrf
  @method('POST')
  <input type="hidden" value="{{ $anuncio }}" name="anuncio">
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
      'size' => ''
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
              <a href="{{ '/usuario/calificaciones/'.$interes->usuario->rut }}" class="btn btn-primary">
                Calificaciones
                <svg class="bi" width="20" height="20" fill="currentColor">
                  <use xlink:href="{{ asset('icons/bootstrap-icons.svg').'#bookmark-star-fill' }}"/>
                </svg>
              </a>
              <!-- Button trigger modal -->
              <button type="button" class="btn btn-primary" onclick="mostrarAntecedentes({{ $interes->usuario }})">
                Antecedentes
                <svg class="bi" width="20" height="20" fill="currentColor">
                  <use xlink:href="{{ asset('icons/bootstrap-icons.svg').'#file-earmark-text-fill' }}"/>
                </svg>
              </button>
              <a href="#" class="btn btn-danger" onclick="{{ __('eliminarInteres('.$anuncio.',"'.$interes->usuario->rut.'")') }}">
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
</script>
@endsection