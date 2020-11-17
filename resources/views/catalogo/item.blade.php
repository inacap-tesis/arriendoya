<div class="col-12">
    <div class="card">
        <div class="row no-gutters">
            <a href="{{ '/anuncio'.'/'.$id }}" class="col-md-4">
                @if (isset($foto))
                <img src="{{ asset('storage/'.$foto) }}" class="rounded img-fluid" style="max-height: 15em;" /> 
                @else
                <img src="{{ asset('images/inmueble_default.png') }}" class="rounded img-fluid" style="max-height: 15em;" /> 
                @endif
            </a>
          <div class="col-md-8">
            <div class="card-body">
                <div class="row">
                    <h6 class="col">
                        <b>{{ __( $titulo ) }}</b>
                    </h6>
                    <small>
                        <i class="col text-right">{{ $fecha }}</i>
                    </small>
                </div>
                <hr>
                <div class="row">
                    <ul>
                        <li class="col">
                            <svg class="bi" width="20" height="20" fill="currentColor" style="margin-right: 1em;">
                                <use xlink:href="{{ asset('icons/bootstrap-icons.svg').'#cash-stack' }}"/>
                            </svg>
                            {{ $canon }}
                        </li>
                        <li class="col">
                            <svg class="bi" width="20" height="20" fill="currentColor" style="margin-right: 1em;">
                                <use xlink:href="{{ asset('icons/bootstrap-icons.svg').'#house-fill' }}"/>
                            </svg>
                            <small>{{ $caracteristicas }}</small>
                        </li>
                    </ul>
                </div>
                <div class="row" style="margin-left:5px; margin-right:5px; position:absolute; bottom:0; left: 0; right: 0;">
                    <hr>
                    <div class="col">
                        <!--<a href="#" class="btn text-warning">
                            <svg class="bi" width="25" height="25" fill="currentColor">
                                <use xlink:href="{{ asset('icons/bootstrap-icons.svg').'#star-half' }}"/>
                            </svg>
                            <span class="badge badge-danger">3</span>
                        </a>-->
                    </div>
                    <div class="col text-right" style="width: 200px;">
                        <a href="{{ '/anuncio'.'/'.$id }}" class="btn">
                            <svg class="bi" width="25" height="25" fill="currentColor">
                                <use xlink:href="{{ asset('icons/bootstrap-icons.svg').'#eye-fill' }}"/>
                            </svg>
                        </a>
                        <!--<a href="#" class="btn text-primary">
                            <svg class="bi" width="25" height="25" fill="currentColor">
                                <use xlink:href="{{ asset('icons/bootstrap-icons.svg').'#hand-thumbs-up' }}"/>
                            </svg>
                        </a>-->
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
</div>