<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Solicitud Finalización
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/solicitud/configurar/{arriendo}', 'SolicitudFinalizacionController@configurar');
Route::get('/solicitud/consultar', 'SolicitudFinalizacionController@consultar');*/
Route::post('/solicitud', 'SolicitudFinalizacionController@registrar');
Route::put('/solicitud', 'SolicitudFinalizacionController@responder');