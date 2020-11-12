@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <form action="/notificacion" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $id }}">
                <input type="hidden" name="tipo" value="{{ $tipo }}">
                <input type="hidden" name="rut" value="{{ $rut }}">
                <div class="form-group">
                    <label for="mensaje">¿Qué problema tiene con el pago?</label>
                    <textarea class="form-control" id="mensaje" name="mensaje" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Aceptar</button>
                <a href="#" class="btn btn-primary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection