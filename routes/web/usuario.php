<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Gestion de usuario
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
//RF-USU-01
Route::get('/usuario/registrar', 'UsuarioController@create');
Route::post('/usuario/registrar', 'UsuarioController@store');

//RF-USU-02
Route::get('/usuario/modificar', function () {
    return view('usuario.modificar');
});

//RF-USU-03
Route::get('/usuario/entrar', function () {
    return view('usuario.entrar');
});

//RF-USU-04
Route::get('/usuario/clave', function() {
    return 'Pendiente por implementar';
});

//RF-USU-05
Route::get('/usuario/recuperar-acceso', function () {
    return view('usuario.recuperar-acceso');
});

//RF-USU-06
Route::get('/antecedentes', function () {
    return view('antecedente.index');
});

//RF-USU-07
Route::get('/usuario/cuenta', 'CuentaBancariaController@consultar');
Route::post('/usuario/cuenta', 'CuentaBancariaController@registrar');
Route::put('/usuario/cuenta', 'CuentaBancariaController@modificar');

//RF-USU-08
Route::get('/cuenta/modificar', function () {
    return view('cuenta.modificar');
});

Route::get('/usuario/antecedentes/{rut}', 'AntecedenteController@listar');

Route::get('/usuario/antecedentes', 'AntecedenteController@listar');
Route::get('/usuario/antecedente', 'AntecedenteController@consultar');
Route::get('/antecedente/modificar/{id}', 'AntecedenteController@consultar');
Route::post('/usuario/antecedente', 'AntecedenteController@registrar');
Route::get('/antecedente/descargar/{id}', 'AntecedenteController@descargar');
Route::get('/antecedente/eliminar/{id}', 'AntecedenteController@eliminar');

//RF-USU-09
Route::get('/antecedente/consultar', function () {
    return view('antecedente.consultar');
});

//RF-USU-10
Route::get('/antecedente/registrar', function () {
    return view('antecedente.registrar');
});

//RF-USU-11
Route::get('/antecedente/modificar', function () {
    return view('antecedente.modificar');
});

//RF-USU-12
Route::get('/antecedente/eliminar', function () {
    return view('antecedente.eliminar');
});

//RF-USU-13
Route::get('/notificaciones', function () {
    return view('notificacion.index');
});*/