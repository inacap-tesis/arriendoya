@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <form id="formulario" class="card" action="/arriendo/iniciar" method="post" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <input type="hidden" name="arriendo" value="{{ $arriendo->id }}">
                <div class="card-header" style="font-weight: bold;">{{ __('Iniciar el Arriendo') }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <p>Por favor considere que no es obligatorio cargar un contrato de arriendo, pero de igual forma es recomendable hacerlo.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="tieneContrato" name="tieneContrato" onchange="_tieneContrato()" style="margin-top: 5px;" checked>
                                        <label class="form-check-label" for="tieneContrato">
                                            Tengo un contrato firmado con el inquilino
                                        </label>
                                      </div>
                                </div>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="documento" name="documento">
                                    <label class="custom-file-label" for="documento">Documento...</label>
                                </div>
                                <span class="invalid-feedback" role="alert">
                                    <strong id="_documento"></strong>
                                </span>
                            </div>
                        </div>
                    </div>  
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="/inmuebles" class="btn btn-primary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    function _tieneContrato() {
        $('#documento').attr('disabled', !$('#tieneContrato')[0].checked);
        $('#documento').attr('required', $('#tieneContrato')[0].checked);
        console.log($('#documento').val());
    }
</script>
@endsection