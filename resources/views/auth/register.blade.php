@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header" style="font-weight: bold;">{{ __('Registrarte') }}</div>

                <div class="card-body">
                    <form id="formulario" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-8">
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="rut">{{ __('RUT') }}</label>
                                        <div>
                                          <input id="rut" type="text" class="form-control @error('rut') is-invalid @enderror" name="rut" value="{{ old('rut') }}" required>
                                          @error('rut')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                        </div>
                                    </div>
                                  </div>
                                  <div class="form-row">
                                    <div class="form-group col">
                                        <label for="primerNombre">{{ __('Primer Nombre') }}</label>
                                        <div>
                                            <input id="primerNombre" type="text" class="form-control @error('primerNombre') is-invalid @enderror" name="primerNombre" value="{{ old('primerNombre') }}" required>
                                            @error('primerNombre')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group col">
                                        <label for="segundoNombre">{{ __('Segundo Nombre') }}</label>
                                        <div>
                                            <input id="segundoNombre" type="text" class="form-control @error('segundoNombre') is-invalid @enderror" name="segundoNombre" value="{{ old('segundoNombre') }}">
                                            @error('segundoNombre')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                  </div>
                                  <div class="form-row">
                                    <div class="form-group col">
                                        <label for="primerApellido">{{ __('Primer Apellido') }}</label>
                                        <div>
                                            <input id="primerApellido" type="text" class="form-control @error('primerApellido') is-invalid @enderror" name="primerApellido" value="{{ old('primerApellido') }}" required>
                                            @error('primerApellido')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group col">
                                        <label for="segundoApellido">{{ __('Segundo Apellido') }}</label>
                                        <div>
                                            <input id="segundoApellido" type="text" class="form-control @error('segundoApellido') is-invalid @enderror" name="segundoApellido" value="{{ old('segundoApellido') }}">
                                            @error('segundoApellido')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                  </div>
                                  <div class="form-row">
                                      <div class="form-group col">
                                        <label for="fechaNacimiento">{{ __('Fecha de Nacimiento') }}</label>
                                        <div>
                                            <input id="fechaNacimiento" type="date" class="form-control @error('fechaNacimiento') is-invalid @enderror" name="fechaNacimiento" value="{{ old('fechaNacimiento') }}" onchange="validarFecha()" required>
                                            <span class="invalid-feedback" role="alert">
                                                <strong id="fechaError">@error('fechaNacimiento') {{ $message }} @enderror</strong>
                                            </span>
                                        </div>
                                      </div>
                                      <div class="form-group col">
                                        <label for="telefono">{{ __('Teléfono') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">+56 9</span>
                                            </div>
                                            <input id="telefono" min="0" max="99999999" type="number" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono') }}" required>
                                            @error('telefono')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                      </div>
                                    </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group col">
                                    <div class="row" style="margin: 29px 0px 50px 0px">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input id="urlFoto" onchange="cambiaFoto()" type="file" class="form-control custom-file-input @error('urlFoto') is-invalid @enderror" name="urlFoto" required autocomplete="urlFoto" autofocus>
                                                <label id="fotoStr" for="urlFoto" class="custom-file-label">{{ __('Buscar foto') }}</label>
                                                @error('urlFoto')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <img id="imagen" src="{{ asset('storage/usuarios/default.png') }}" class="rounded img-fluid" style="max-height: 200px;" alt="Responsive image">
                                    </div>
                                  </div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                          <div class="form-group col-md-8">
                            <label for="email">{{ __('Correo Electrónico') }}</label>
                            <div>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-4">
                            <label for="password">{{ __('Contraseña') }}</label>
                            <div>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                          </div>
                          <div class="form-group col-md-4">
                            <label for="password-confirm">{{ __('Confirmar Contraseña') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                          </div>
                        </div>
                          <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="terminos" onchange="cambiaTerminos()">
                            <label class="form-check-label text-secondary" for="terminos">
                                Estoy de cuerdo con los
                                <a href="#">Términos y condiciones.</a>
                            </label>
                            <span class="invalid-feedback" role="alert">
                                <strong>Debe aceptar los términos y condiciones.</strong>
                            </span>
                          </div>
                          <div class="form-group">
                            <a class="col-md-4 btn btn-primary" onclick="validarTerminos()">{{ __('Registrar') }}</a>
                            <a href="/" class="col-md-4 btn btn-primary">Cancelar</a>
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
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagen').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
            return true;
        } else {
            var url = '{{ asset("") }}' + 'storage/usuarios/default.png';
            $('#imagen').attr('src', url);
            return false;
        }
    }

    function cambiaFoto() {
        file = $("#urlFoto")[0];
        $('#fotoStr').text(file && readURL($("#urlFoto")[0]) ? file.files[0].name : 'Buscar foto');
    }

    function validarTerminos() {
        if($('#terminos').prop('checked')) {
            if(validarFecha()){
                $('#formulario').submit();
            }
        } else {
            $('#terminos').addClass('is-invalid');
        }
    }

    function cambiaTerminos() {
        if($('#terminos').prop('checked')) {
            $('#terminos').removeClass('is-invalid');
        } else {
            $('#terminos').addClass('is-invalid');
        }
    }

    function validarFecha() {
        var fecha = new Date($('#fechaNacimiento').val() + ' 00:00:00');
        var fechaRef = new Date();
        fechaRef.setYear(fechaRef.getFullYear() - 18);
        if(fecha > fechaRef) {
            $('#fechaNacimiento').addClass('is-invalid');
            $('#fechaError').empty();
            $('#fechaError').text('No puedo ser menor de edad.');
            return false;
        } else {
            $('#terminos').removeClass('is-invalid');
            $('#fechaError').empty();
            return true;
        }
    }
</script>
@endsection