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
              @if ($boton[0] == 'Eliminar' || $boton[0] == 'No arrendar')
              <form id="{{ 'delete'.$id }}" style="display: none;" action="{{ $boton[1] }}" method="post">
                @method('DELETE')
                @csrf
                <input type="hidden" name="id" value="{{$id}}">
              </form>
              <a href="#" class="text-dark" style="text-decoration: unset; font-weight: bold;" onclick="{{ 'forms.delete'.$id.'.submit();' }}">
                {{ $boton[0] }}
              </a>
              @elseif ($boton[0] == 'Dar de baja' || $boton[0] == 'Reactivar')
              <form id="{{ 'inm'.$id }}" style="display: none;" action="{{ $boton[1] }}" method="post">
                @method('PUT')
                @csrf
                <input type="hidden" name="id" value="{{$id}}">
              </form>
              <a href="#" class="text-dark" style="text-decoration: unset; font-weight: bold;" onclick="{{ 'forms.inm'.$id.'.submit();' }}">
                {{ $boton[0] }}
              </a>
              @else
              <a href="{{ $boton[1].'/'.$id }}" class="text-dark" style="text-decoration: unset; font-weight: bold;">{{ $boton[0] }}</a>
              @endif
            </li>
            @endforeach    
          </ul>
        </div>
      </div>
</div>