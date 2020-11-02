<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Gestion de inmuebles
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/inmueble/catalogo', 'InmuebleController@listar');

//RF-INM-01
Route::get('/inmueble/registrar', 'InmuebleController@consultar');
Route::post('/inmueble/registrar', 'InmuebleController@registrar');

//RF-INM-02
Route::get('/inmueble/modificar/{id}', ['uses'=>'InmuebleController@consultar']);
Route::put('/inmueble/modificar', ['uses'=>'InmuebleController@modificar']);

//RF-INM-03
Route::put('/inmueble/baja', ['uses'=>'InmuebleController@desactivar']);

//RF-INM-04
Route::delete('/inmueble/eliminar', 'InmuebleController@eliminar');

//RF-INM-05
Route::put('/inmueble/alta', 'InmuebleController@activar');

//RF-INM-06
Route::get('/inmueble/publicar/{id}', ['uses'=>'AnuncioController@configurar']);
Route::post('/inmueble/publicar', 'AnuncioController@activar')->name('publicar');

//RF-INM-07
Route::get('/inmueble/anuncio/{id}', ['uses'=>'AnuncioController@desactivar']);

//RF-INM-08
Route::get('/anuncio/interesados/{id}', ['uses'=>'AnuncioController@verInteresados']);

//RF-INM-09
Route::get('/arriendo/consultar', function () {
    return view('arriendo.consultar');
});

//RF-INM-10
Route::get('/inmueble/arrendar', function () {
    return view('inmueble.arrendar');
});

//RF-INM-11
Route::get('/inmueble/no-arrendar', function () {
    return view('inmueble.no-arrendar');
});

//RF-INM-12
Route::get('/inmueble/contrato/{id}', function () {
    return view('inmueble.contrato');
});

//RF-INM-13
Route::get('/arriendo/iniciar', function () {
    return view('arriendo.iniciar');
});

//RF-INM-14
Route::get('/anuncio/filtrar', function () {
    return view('anuncio.filtrar');
});

//RF-INM-15
Route::get('/anuncio/ordenar', function () {
    return view('anuncio.ordenar');
});

Route::get('/anuncio/{id}', ['uses'=>'AnuncioController@consultar']);

Route::get('/anuncio/interes/{id}', ['uses'=>'AnuncioController@mostrarInteres']);
Route::get('/anuncio/desinteres/{id}', ['uses'=>'AnuncioController@quitarInteres']);

Route::post('/anuncio/candidatos', ['uses'=>'AnuncioController@definirCandidatos']);

Route::get('/anuncio/interes/eliminar/{anuncio}/{usuario}', ['uses'=>'AnuncioController@eliminarInteresado']);