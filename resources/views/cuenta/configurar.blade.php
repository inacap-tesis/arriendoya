@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Cuenta Bancaria</h3>
    <form action="/usuario/cuenta" method="POST">
        @csrf
        <div class="row">
            <div class="col-8">
                <div class="form-group">
                    <label for="banco">{{ __('Banco') }}</label>
                    <select class="form-control" id="banco" name="banco" required>
                        @foreach ($bancos as $banco)
                        <option value="{{$banco->id}}" @if ($cuenta && $cuenta->idBanco == $banco->id) selected @endif>{{$banco->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="tipo">{{ __('Tipo de cuenta') }}</label>
                    <select class="form-control" id="tipo" name="tipo" required>
                        @foreach ($tipos as $tipo)
                        <option value="{{$tipo->id}}" @if ($cuenta && $cuenta->idTipo == $tipo->id) selected @endif>{{$tipo->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="numero">{{ __('Número de cuenta') }}</label>
                    <input type="text" class="form-control" id="numero" name="numero" @if ($cuenta) value="{{ $cuenta->numero }}" @endif required>
                </div>
            </div>
        </div>   
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="/" class="btn btn-primary">Cancelar</a>
    </form>
</div>
@endsection