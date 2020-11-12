@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="/antecedente" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" class="form-control @error('titulo') is-invalid @enderror" id="titulo" name="titulo" value="{!! old('titulo') !!}">
                @error('titulo')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <div class="input-group mb-3">
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
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="/usuario/antecedentes" class="btn btn-primary">Cancelar</a>
        </form>
    </div>
@endsection