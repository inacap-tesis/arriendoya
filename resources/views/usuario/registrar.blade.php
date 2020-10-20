@extends('layouts.app')

@section('content')
<div class="container" style="margin-top:20px">
    <h3>Registrarte</h3>
    <form action="/usuario/registrar" method="POST">
        @csrf
        <div class="form-group">
            <label for="rut">RUT</label>
            <input type="text" class="form-control" id="rut" name="rut" required>
        </div>
        <div class="form-group">
            <label for="primerNombre">Primer Nombre</label>
            <input type="text" class="form-control" id="primerNombre" name="primerNombre" required>
        </div>
        <div class="form-group">
            <label for="segundoNombre">Segundo Nombre</label>
            <input type="text" class="form-control" id="segundoNombre" name="segundoNombre">
        </div>
        <div class="form-group">
            <label for="primerApellido">Primer Apellido</label>
            <input type="text" class="form-control" id="primerApellido" name="primerApellido" required>
        </div>
        <div class="form-group">
            <label for="segundoApellido">Segundo Apellido</label>
            <input type="text" class="form-control" id="segundoApellido" name="segundoApellido">
        </div>
        <div class="form-group">
            <label for="fechaNacimiento">Fecha de Nacimiento</label>
            <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" required>
        </div>
        <div class="form-group">
            <label for="correo">Correo Electrónico</label>
            <input type="email" placeholder="user@domain.com" class="form-control" id="correo" name="correo" required>
        </div>
        <div class="form-group">
            <label for="clave">Contraseña</label>
            <input type="password" class="form-control" id="clave" name="clave" required>
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">+56-9</span>
                </div>
                <input type="number" min="0" max="99999999" class="form-control" id="telefono" name="telefono" required>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Guardar</button>
        <a href="/" class="btn btn-primary">Cancelar</a>
    </form>
</div>
@endsection