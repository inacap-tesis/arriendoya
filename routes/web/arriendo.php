<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Gestion de arriendos
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/arriendo/configurar/{id}/', 'ArriendoController@formularioConfigurar');
Route::post('/arriendo/configurar', 'ArriendoController@configurar');

Route::get('/arriendo/cancelar/{id}/', 'ArriendoController@cancelar');

Route::get('/arriendo/iniciar/{id}/', 'ArriendoController@formularioIniciar');
Route::post('/arriendo/iniciar', 'ArriendoController@iniciar');

Route::get('/arriendo/catalogo', 'ArriendoController@catalogo');

Route::get('/arriendo/consultar/{id}/', 'ArriendoController@consultar');

Route::get('/deuda/pagar/{id}/', 'DeudaController@formularioPagar');
Route::post('/deuda/pagar', 'DeudaController@pagar');

Route::get('/deuda/comprobante/{id}/', 'DeudaController@descargarComprobante');

//RF-ARR-01
Route::get('/arriendo/recordar-pago', function () {
    return view('arriendo.recordar-pago');
});

//RF-ARR-02
Route::get('/arriendo/morosidad', function () {
    return view('arriendo.morosidad');
});

//RF-ARR-03
Route::get('/arriendo/renovacion', function () {
    return view('arriendo.renovacion');
});

//RF-ARR-04
Route::get('/arriendo/resumen', function () {
    return view('arriendo.resumen');
});

//RF-ARR-05
Route::get('/arriendo/contrato', function () {
    return view('arriendo.contrato');
});

//RF-ARR-06
Route::get('/arriendo/finalizacion/solicitar', function () {
    return view('arriendo.solicitar-finalizacion');
});

//RF-ARR-07
Route::get('/arriendo/solicitud/responder', function () {
    return view('arriendo.responder-solicitar-finalizacion');
});