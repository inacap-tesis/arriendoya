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

Route::get('/arriendos', 'ArriendoController@listar');
Route::get('/arriendo/configurar/{id}', 'ArriendoController@configurar');
Route::get('/arriendo/{id}', 'ArriendoController@consultar'); //RF-INM-09
Route::post('/arriendo', 'ArriendoController@registrar'); //RF-INM-10
Route::put('/arriendo', 'ArriendoController@modificar');
Route::delete('/arriendo', 'ArriendoController@eliminar'); //RF-INM-11
Route::get('/arriendo/cargarContrato/{id}', 'ArriendoController@cargarContrato');
Route::post('/arriendo/iniciar', 'ArriendoController@iniciar'); //RF-INM-13
Route::get('/arriendo/descargarContrato/{id}', 'ArriendoController@descargarContrato'); //RF-ARR-05
Route::get('/arriendo/formato', 'ArriendoController@obtenerContrato'); //RF-INM-12
Route::post('/arriendo/finalizar', 'ArriendoController@finalizarForzosamente'); //RF-ARR-12