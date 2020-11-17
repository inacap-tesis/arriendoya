@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header" style="font-weight: bold;">
                    {{ $esPropietario ? 'Calificar a '.$usuario->primerNombre.' '.$usuario->primerApellido : "Calificar el Arriendo" }}
                </div>

                <div class="card-body text-center">
                    <form method="POST" action="/calificacion">
                        @csrf

                        <!--comentario-->
                        <div class="form-group row">
                            <div class="col-2"></div>
                            <textarea class="form-control col-8" id="comentario" name="comentario" rows="7" placeholder="¿Cómo definiría su experiencia durante el arriendo?" required></textarea>
                            <span class="invalid-feedback" role="alert">
                                <strong id="msgComentario"></strong>
                            </span>
                        </div>

                        <h5>¿Qué nivel de satisfacción significó para usted?</h5>
                        <!--nota-->
                        <div class="btn-group" role="group" aria-label="Basic example">
                          <button type="button" class="btn text-danger" style="padding: 20px;" onclick="calificar(1)">
                            <svg class="bi" width="40" height="40" fill="currentColor">
                                <use xlink:href="{{ asset('icons/bootstrap-icons.svg').'#star' }}"/>
                            </svg>
                            <br>
                            <br>
                            <h5 class="text-secondary">1</h5>
                          </button>
                          <button type="button" class="btn text-warning" style="padding: 20px;"onclick="calificar(2)">
                            <svg class="bi" width="40" height="40" fill="currentColor">
                                <use xlink:href="{{ asset('icons/bootstrap-icons.svg').'#star' }}"/>
                            </svg>
                            <br>
                            <br>
                            <h5 class="text-secondary">2</h5>
                          </button>
                          <button type="button" class="btn text-warning" style="padding: 20px;" onclick="calificar(3)">
                            <svg class="bi" width="40" height="40" fill="currentColor">
                                <use x="-24" y="-50" transform="rotate(145)" xlink:href="{{ asset('icons/bootstrap-icons.svg').'#star-half' }}"/>
                            </svg>
                            <br>
                            <br>
                            <h5 class="text-secondary">3</h5>
                          </button>
                          <button type="button" class="btn text-warning" style="padding: 20px;" onclick="calificar(4)">
                            <svg class="bi" width="40" height="40" fill="currentColor">
                                <use xlink:href="{{ asset('icons/bootstrap-icons.svg').'#star-fill' }}"/>
                            </svg>
                            <br>
                            <br>
                            <h5 class="text-secondary">4</h5>
                          </button>
                          <button type="button" class="btn text-success" style="padding: 20px;" onclick="calificar(5)">
                            <svg class="bi" width="40" height="40" fill="currentColor">
                                <use xlink:href="{{ asset('icons/bootstrap-icons.svg').'#star-fill' }}"/>
                            </svg>
                            <br>
                            <br>
                            <h5 class="text-secondary">5</h5>
                          </button>
                        </div>
                        <br>
                        <br>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    function calificar(nota) {
        $('#msgComentario').empty();
        var comentario = $('#comentario').val();
        if(comentario && comentario != '') {
            $.ajax({
                url: '/calificacion',
                type: "POST",
                dataType: 'json',//this will expect a json response
                data: {
                  _token: '{{ csrf_token() }}',
                  nota,
                  comentario,
                  esPropietario: '{{ $esPropietario }}',
                  arriendo: '{{ $arriendo->id }}'
                }, 
                success: function(response) {
                    window.location.href = response > 0 ? '/inmuebles' : "/arriendos";
                }
            });
        } else {
            $('#msgComentario').text('Su opinión es muy importante para nosotros, por favor permítanos conocer su experiencia.');
            $('#comentario').addClass('is-invalid');
        }
    }
</script>
@endsection