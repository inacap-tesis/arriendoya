<div class="col mb-4">
    <div class="card border-{{ $color }}" style="border-width: initial;">
        <div class="card-header" style="font-weight: bold;">
            {{ $tipo.' en '.$direccion }}
        </div>
        <div class="card-body">
          <h6 class="card-title" style="text-decoration: underline;">Características:</h6>
          <p class="card-text">{{ $caracteristicas }}</p>
            <ul class="list-group">
            @foreach ($botones as $boton)
            <li class="list-group-item border-{{ $color }}">
                <a href="{{ $boton[1].'/'.$id }}" class="text-dark" style="text-decoration: unset; font-weight: bold;">{{ $boton[0] }}</a>
            </li>
            @endforeach    
          </ul>
        </div>
      </div>
</div>