@extends('layouts.app')

@section('content')
<div class="container">
  <form action="/anuncio/candidatos" method="POST">
    @csrf
    @method('POST')
    <input type="hidden" value="{{ $anuncio->idInmueble }}" name="anuncio">
    @foreach ($interesados as $interesado)
        <div class="row">
          <div class="col">
            {{ __($interesado->primerNombre.' '.$interesado->segundoNombre.' '.$interesado->primerApellido.' '.$interesado->segundoApellido) }}
          </div>
          <div class="col">
            <a href="{{ '/usuario/calificaciones/'.$anuncio->id.'/'.$interesado->rut }}" class="btn btn-primary">Ver calificaciones</a>
          </div>
          <div class="col">
            <a href="{{ '/usuario/antecedentes/'.$anuncio->id.'/'.$interesado->rut }}" class="btn btn-primary">Ver antecedentes</a>
          </div>
          <div class="col">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="{{ $interesado->rut }}" id="{{ $interesado->rut }}">
              <label class="form-check-label" for="{{ $interesado->rut }}">
                Es candidato
              </label>
            </div>
          </div>
          <div class="col">
            <a href="{{ '/usuario/interes/eliminar/'.$anuncio->id.'/'.$interesado->rut }}" class="btn btn-danger">Eliminar</a>
          </div>
        </div>
    @endforeach
    <div class="row">
      <div class="col">
        <button type="submit" class="btn btn-primary">Aceptar</button>
      </div>
      <div class="col">
        <a href="/inmueble/catalogo" class="btn btn-primary">Cancelar</a>
      </div>
    </div>
  </form>
</div>
@endsection