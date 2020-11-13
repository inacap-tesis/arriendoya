<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Deuda
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/deuda/listar', 'DeudaController@listar');
Route::get('/deuda/pago/{id}', 'PagoDeudaController@configurar');
Route::post('/deuda/pago', 'PagoDeudaController@registrar');
Route::get('/deuda/pago/comprobante/{id}', 'PagoDeudaController@descargarComprobante');
Route::post('/deuda/pago/problema', 'PagoDeudaController@reportarProblema');
Route::get('/deuda/pago/problema', 'PagoDeudaController@consultarProblema');