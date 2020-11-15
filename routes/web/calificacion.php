<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Calificación
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/calificaciones/{usuario}', 'CalificacionController@consultar');
Route::get('/calificacion/{arriendo}', 'CalificacionController@configurar');
Route::post('/calificacion', 'CalificacionController@calificar');

Route::get('/calificacion/arriendo/configurar', 'CalificacionController@configurarParaArriendo');
Route::post('/calificacion/inquilino/registrar', 'CalificacionController@paraInquilino');
Route::post('/calificacion/arriendo/registrar', 'CalificacionController@paraArriendo');
Route::get('/calificacion/propietario/listar', 'CalificacionController@dePropietario');
Route::get('/calificacion/inmueble/listar', 'CalificacionController@deInmueble');
Route::get('/calificacion/inquilino/listar', 'CalificacionController@deInquilino');