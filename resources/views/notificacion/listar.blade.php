@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col">
            <h3>Mis Notificaciones</h3>
        </div>
    </div>
    <br>
    <div class="accordion" id="notificaciones">
        @foreach (Auth::user()->notifications as $notificacion)
        <div class="card" id="{{ __($notificacion->id.'_') }}">
            <div class="card-header" id="{{ __($notificacion->id) }}">
              <h2 class="mb-0">
                <button onclick="leer('{{ $notificacion->id }}')" class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#{{ __('_'.$notificacion->id) }}" aria-expanded="true" aria-controls="{{ __('_'.$notificacion->id) }}">
                    <div class="row">
                        <div class="col">
                            {{ $notificacion->data['titulo'] }}
                            @if (!$notificacion->read_at)
                            <span id="{{ __('n'.$notificacion->id) }}" class="badge badge-danger">No leida</span>
                            @endif
                        </div>
                        <div class="col text-right">
                            <a class="text-danger" onclick="eliminar('{{ $notificacion->id }}')">
                                <svg class="bi" width="20" height="20" fill="currentColor">
                                  <use xlink:href="{{ asset('icons/bootstrap-icons.svg').'#trash-fill' }}"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </button>
              </h2>
            </div>
        
            <div id="{{ __('_'.$notificacion->id) }}" class="collapse @if($notificacion->read_at && $loop->index == 0) show @endif" aria-labelledby="{{ __($notificacion->id) }}" data-parent="#notificaciones">
              <div class="card-body">
                {{ $notificacion->data['mensaje'] }}
                @if ($notificacion->type == 'App\Notifications\ArriendoNotificacion' && $notificacion->data['tipo'] == 2)
                    <p>
                      <br>
                      <a href="#" class="btn btn-danger" onclick="noRenovar({{ $notificacion->data['arriendo'] }})">No quiero que se renueve</a>
                    </p>
                @endif
              </div>
            </div>
          </div>
        @endforeach
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    function leer(id) {
        var badge = $('#n' + id).length;
        if(badge) {
            $.ajax({
                url: '/notificacion',
                type: "PUT",
                dataType: 'json',//this will expect a json response
                data: { 
                  '_token': '{{ csrf_token() }}',
                    id 
                  }, 
                success: function(response) {
                    $('#n' + response.id).remove();
                }
            });
        }
    }

    function eliminar(id) {
        $.ajax({
            url: '/notificacion',
            type: "DELETE",
            dataType: 'json',//this will expect a json response
            data: { 
              '_token': '{{ csrf_token() }}',
                id 
              }, 
            success: function(response) {
                $('#' + response.id + '_').remove();
            }
        });
    }

    function noRenovar(id) {
      $.ajax({
          url: '/arriendo/noRenovar',
          type: "PUT",
          dataType: 'json',//this will expect a json response
          data: { 
            '_token': '{{ csrf_token() }}',
              id 
            }, 
          success: function(response) {
            //Informar al usuario
            console.log(response);
          }
      });
    }
</script>
@endsection
