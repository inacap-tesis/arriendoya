@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top:20px">
        <div class="row">
            <h3 class="col-10">Mis Inmuebles</h3>
            <a href="/inmueble/registrar" class="col-2 btn btn-primary">Agregar</a>
        </div>
        <div class="row">
            <div class="col">
                @foreach ($inmuebles as $inmueble)
                <label>{{$inmueble->direccion}}</label>
                @endforeach
            </div>
        </div>
    </div>
@endsection