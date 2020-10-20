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
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row no-gutters">
                      <div class="col-md-4">
                        <img src="https://i.pinimg.com/originals/5a/91/85/5a91851234dbe24a2a0630bb95dd16fe.jpg" class="card-img" alt="...">
                      </div>
                      <div class="col-md-8">
                        <div class="card-body">
                          <h5 class="card-title">{{ $inmueble->calleDireccion.' '.$inmueble->numeroDireccion }}</h5>
                          <p class="card-text">{{ $inmueble->caracteristicas }}</p>
                          <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection