@extends('index')

@section('content')
<div class="row" style="margin-top: 50px"></div>
<div class="row">
    <div class="col-4"></div>
    <div class="col-4">

        <form action="">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Iniciar Sesión</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">RUT</label>
                        <input type="email" class="form-control form-control" id="rut">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Clave</label>
                        <input type="password" class="form-control form-control" id="clave">
                      </div>
                </div>
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-primary" id="entrar">Entrar</button>
                    <button type="submit" class="btn btn-primary" id="cancelar">Cancelar</button>
                    <br>
                    <a class="font-weight-light" href="/usuario/registrar">Registrarme</a>
                    <label> | </label>
                    <a class="font-weight-light" href="/usuario/recuperar-acceso">Olvidé mi clave</a>
                </div>
            </div>
        </form>
    </div>
    <div class="col-4"></div>
</div>
@endsection