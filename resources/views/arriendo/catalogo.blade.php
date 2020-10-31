@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row row-cols-1 row-cols-md-3 bg-secondary">
        @foreach ($arriendos as $arriendo)
        @if ($arriendo->estado)
            <div class="col mb-3">
                <div class="card" style="width: 16.8rem;">
                    <div class="card-body">
                      <h5 class="card-title">{{ __( 'Dirección: '.$arriendo->inmueble->calleDireccion.' '.$arriendo->inmueble->numeroDireccion ) }}</h5>
                      <h6 class="card-subtitle mb-2 text-muted">{{ __( 'Canon: $'.$arriendo->canon ) }}</h6>
                      <p class="card-text">{{ __( 'Fecha inicio: '.$arriendo->fechaInicio ) }}</p>
                      <p class="card-text">{{ __( 'Fecha término: '.$arriendo->fechaTerminoPropuesta ) }}</p>
                      <p class="card-text">{{ __( 'Día de pago: El '.$arriendo->diaPago.' de cada mes.' ) }}</p>
                      <p class="card-text">{{ __( ($arriendo->subarriendo ? 'Se': 'No se').' permite subarrendar.' ) }}</p>
                      @if ($arriendo->garantia)
                      <p class="card-text">{{ __( 'Garantía: $'.$arriendo->garantia ) }}</p>
                      @endif
                      <a href="{{ '/arriendo/consultar/'.$arriendo->id }}" class="card-link">Consultar</a>
                    </div>
                </div>
            </div>
        @endif
        @endforeach
    </div>
</div>
@endsection