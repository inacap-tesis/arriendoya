<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Notificacion
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/notificaciones{rut}', 'NotificacionController@listar');
Route::get('/notificacion/{id}', 'NotificacionController@consultar');
Route::post('/notificacion', 'NotificacionController@registrar');