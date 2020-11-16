@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header" style="font-weight: bold;">{{ __('Mi Cuenta Bancaria') }}</div>
                <div class="card-body">
                    <form action="/cuenta" method="POST">
                        @csrf
                        @if ($cuenta)
                        @method('PUT')
                        @endif
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="banco">{{ __('Banco') }}</label>
                                <select class="form-control" id="banco" name="banco" required>
                                    @foreach ($bancos as $banco)
                                    <option value="{{$banco->id}}" @if ($cuenta && $cuenta->idBanco == $banco->id) selected @endif>{{$banco->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col">
                                <label for="tipo">{{ __('Tipo de cuenta') }}</label>
                                <select class="form-control" id="tipo" name="tipo" required>
                                    @foreach ($tipos as $tipo)
                                    <option value="{{$tipo->id}}" @if ($cuenta && $cuenta->idTipo == $tipo->id) selected @endif>{{$tipo->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="numero">{{ __('Número de cuenta') }}</label>
                                <input type="text" class="form-control" id="numero" name="numero" @if ($cuenta) value="{{ $cuenta->numero }}" @endif required>
                            </div>
                        </div>   
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="/" class="btn btn-primary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>    
</div>
@endsection