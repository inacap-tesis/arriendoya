@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header" style="font-weight: bold;">{{ __('Mis Antecedentes') }}</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col text-right">
                                <a href="/antecedente" class="btn btn-success">
                                    Agregar
                                    <svg class="bi" width="20" height="20" fill="currentColor">
                                        <use xlink:href="{{ asset('icons/bootstrap-icons.svg').'#plus' }}"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <br>
                        <table class="table">
                            <tbody>
                                @foreach ($antecedentes as $antecedente)
                                    <tr>
                                        <th scope="row">{{$antecedente->titulo}}</th>
                                        <td class="row d-flex justify-content-end">
                                            <a style="position: relative; right: 5px;" href="{{ '/antecedente/'.$antecedente->id }}" class="btn btn-primary">
                                                Descargar
                                                <svg class="bi" width="20" height="20" fill="currentColor">
                                                    <use xlink:href="{{ asset('icons/bootstrap-icons.svg').'#download' }}"/>
                                                </svg>
                                            </a>
                                            @if ($antecedente->usuario->rut == Auth::user()->rut)
                                            <form action="/antecedente" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="id" value="{{ $antecedente->id }}">
                                                <button type="submit" class="btn btn-danger">
                                                    Eliminar
                                                    <svg class="bi" width="20" height="20" fill="currentColor">
                                                      <use xlink:href="{{ asset('icons/bootstrap-icons.svg').'#trash-fill' }}"/>
                                                    </svg>
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection