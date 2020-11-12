@extends('layouts.app')

@section('content')
    <div class="container">
        <br>
        <div class="row">
            <div class="col text-center">
                <h2>Aantecedentes</h2>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col text-right">
                <a href="/antecedente" class="btn btn-success">Agregar</a>
            </div>
        </div>
        <br>
        <table class="table">
            <tbody>
                @foreach ($antecedentes as $antecedente)
                    <tr>
                        <th scope="row">{{$antecedente->titulo}}</th>
                        <td>
                            <a href="{{ '/antecedente/'.$antecedente->id }}" class="btn btn-primary">Descargar</a>
                        </td>
                        @if ($antecedente->usuario->rut == Auth::user()->rut)
                        <td>
                            <form action="/antecedente" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $antecedente->id }}">
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection