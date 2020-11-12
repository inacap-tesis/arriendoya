@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/arriendo/iniciar" method="post" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <input type="hidden" name="arriendo" value="{{ $arriendo->id }}">
        <div class="input-group mb-3">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="documento" name="documento">
                <label class="custom-file-label" for="documento">Documento...</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="/inmueble/catalogo" class="btn btn-primary">Cancelar</a>
    </form>
</div>
@endsection