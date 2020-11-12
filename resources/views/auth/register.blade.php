@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('Registrarte') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <!--rut-->
                        <div class="form-group row">
                            <label for="rut" class="col-md-4 col-form-label text-md-right">{{ __('RUT') }}</label>

                            <div class="col-md-6">
                                <input id="rut" type="text" class="form-control @error('rut') is-invalid @enderror" name="rut" value="{{ old('rut') }}" required autocomplete="rut" autofocus>

                                @error('rut')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!--primerNombre-->
                        <div class="form-group row">
                            <label for="primerNombre" class="col-md-4 col-form-label text-md-right">{{ __('Primer Nombre') }}</label>

                            <div class="col-md-6">
                                <input id="primerNombre" type="text" class="form-control @error('primerNombre') is-invalid @enderror" name="primerNombre" value="{{ old('primerNombre') }}" required autocomplete="primerNombre" autofocus>

                                @error('primerNombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!--segundoNombre-->
                        <div class="form-group row">
                            <label for="segundoNombre" class="col-md-4 col-form-label text-md-right">{{ __('Segundo Nombre') }}</label>

                            <div class="col-md-6">
                                <input id="segundoNombre" type="text" class="form-control @error('segundoNombre') is-invalid @enderror" name="segundoNombre" value="{{ old('segundoNombre') }}" autocomplete="segundoNombre" autofocus>

                                @error('segundoNombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!--primerApellido-->
                        <div class="form-group row">
                            <label for="primerApellido" class="col-md-4 col-form-label text-md-right">{{ __('Primer Apellido') }}</label>

                            <div class="col-md-6">
                                <input id="primerApellido" type="text" class="form-control @error('primerApellido') is-invalid @enderror" name="primerApellido" value="{{ old('primerApellido') }}" required autocomplete="primerApellido" autofocus>

                                @error('primerApellido')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!--segundoApellido-->
                        <div class="form-group row">
                            <label for="segundoApellido" class="col-md-4 col-form-label text-md-right">{{ __('Segundo Apellido') }}</label>

                            <div class="col-md-6">
                                <input id="segundoApellido" type="text" class="form-control @error('segundoApellido') is-invalid @enderror" name="segundoApellido" value="{{ old('segundoApellido') }}" autocomplete="segundoApellido" autofocus>

                                @error('segundoApellido')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!--fechaNacimiento-->
                        <div class="form-group row">
                            <label for="fechaNacimiento" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de Nacimiento') }}</label>

                            <div class="col-md-6">
                                <input id="fechaNacimiento" type="date" class="form-control @error('fechaNacimiento') is-invalid @enderror" name="fechaNacimiento" value="{{ old('fechaNacimiento') }}" required autocomplete="fechaNacimiento" autofocus>

                                @error('fechaNacimiento')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!--telefono-->
                        <div class="form-group row">
                            <label for="telefono" class="col-md-4 col-form-label text-md-right">{{ __('Teléfono') }}</label>

                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">+56 9</span>
                                </div>
                                <input id="telefono" min="0" max="99999999" type="number" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono') }}" required autocomplete="telefono" autofocus>

                                @error('telefono')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <!--urlFoto-->
                        <div class="from-group row" style="margin-bottom: 15px">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Foto') }}</label>
                            
                            <div class="input-group col-md-6">
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
                        
                        <!--email-->
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Correo Electrónico') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!--password-->
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!--password_confirmation-->
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar Contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                                <a href="/" class="btn btn-primary">Cancelar</a>
                            </div>
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
    function cambiaFoto() {
        file = $("#urlFoto")[0].files[0];
        $('#fotoStr').text(file ? file.name : 'Buscar foto');

        // Creamos el objeto de la clase FileReader
        //let reader = new FileReader();

        // Leemos el archivo subido y se lo pasamos a nuestro fileReader
        //reader.readAsDataURL(file);

        // Le decimos que cuando este listo ejecute el código interno
        /*reader.onload = function(){
          let preview = document.getElementById('preview'),
                  image = document.createElement('img');
        
          image.src = reader.result;
        
          preview.innerHTML = '';
          preview.append(image);
        };*/
    }
</script>
@endsection