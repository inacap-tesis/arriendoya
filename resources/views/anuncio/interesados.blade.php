@extends('layouts.app')

@section('content')
<div class="container">
  <form action="/anuncio/candidatos" method="POST">
    @csrf
    @method('POST')
    <input type="hidden" value="{{ $anuncio->idInmueble }}" name="anuncio">
    @foreach ($intereses as $interes)
        <div class="row">
          <div class="col">
            {{ __($interes->usuario->primerNombre.' '.$interes->usuario->segundoNombre.' '.$interes->usuario->primerApellido.' '.$interes->usuario->segundoApellido) }}
          </div>
          <div class="col">
            <a href="{{ '/usuario/calificaciones/'.$anuncio->idInmueble.'/'.$interes->usuario->rut }}" class="btn btn-primary">Ver calificaciones</a>
          </div>
          <div class="col">
            <a href="{{ '/usuario/antecedentes/'.$anuncio->idInmueble.'/'.$interes->usuario->rut }}" class="btn btn-primary">Ver antecedentes</a>
          </div>
          <div class="col">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="{{ $interes->usuario->rut }}" id="{{ $interes->usuario->rut }}" @if ($interes->candidato) checked @endif>
              <label class="form-check-label" for="{{ $interes->usuario->rut }}">
                Es candidato
              </label>
            </div>
          </div>
          <div class="col">
            <a href="{{ '/anuncio/interes/eliminar/'.$anuncio->idInmueble.'/'.$interes->usuario->rut }}" class="btn btn-danger">Eliminar</a>
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