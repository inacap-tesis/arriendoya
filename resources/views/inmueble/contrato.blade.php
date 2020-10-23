@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="text-center">¿De qué manera desea obtener un contrato de arriendo?</h4>
    <br>
    <div class="row text-center">
        <div class="col-4">
            <h5>Descargar formato</h5>
            <a href="#">
                <img src="{{ asset('/images/imagotipo.png') }}" alt="NotarioExpress" style="max-width: 250px; margin: 20px;">
            </a>
        </div>
        <div class="col-4">
            <h5 >Agendar visita en notaría</h5>
            <a href="https://www.notarioexpress.cl/contratodearriendo" target="_blank">
                <img src="https://www.notarioexpress.cl/images/logo.png" alt="NotarioExpress" style="max-width: 300px; margin: 20px;">
            </a>
        </div>
        <div class="col-4">
            <h5>Contrato Online</h5>
            <div class="bg-primary rounded-lg">
                <a href="https://www.legalchile.cl/contrato-de-arriendo/" target="_blank">
                    <img src="https://www.legalchile.cl/wp-content/uploads/2019/02/cropped-legalchile-logo.png" alt="NotarioExpress" style="max-width: 300px; margin: 20px;">
                </a>
            </div>
        </div>
    </div>
</div>
@endsection