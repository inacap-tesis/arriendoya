@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header" style="font-weight: bold;">{{ __('Registrar Antecedete') }}</div>
                    <div class="card-body">
                        <form action="/antecedente" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="titulo">Título</label>
                                    <input type="text" class="form-control @error('titulo') is-invalid @enderror" id="titulo" name="titulo" value="{!! old('titulo') !!}">
                                    @error('titulo')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col">
                                    <div class="input-group mb-3" style="position: relative; top: 30px;">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="documentoInfo">Documento</span>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input @error('documento') is-invalid @enderror" id="documento" name="documento" aria-describedby="documentoInfo">
                                            <label class="custom-file-label" for="documento">Buscar</label>
                                        </div>
                                    </div>
                                    @error('documento')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Registrar</button>
                            <a href="/antecedentes" class="btn btn-primary">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection