<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Garantía
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/garantia/pago/{id}', 'PagoGarantiaController@configurar');
Route::post('/garantia/pago/', 'PagoGarantiaController@registrar');
Route::get('/garantia/pago/comprobante/{id}', 'PagoGarantiaController@descargarComprobante');
Route::post('/garantia/pago/problema', 'PagoGarantiaController@reportarProblema');

Route::get('/garantia/devolucion/{id}', 'DevolucionGarantiaController@configurar');
Route::post('/garantia/devolucion', 'DevolucionGarantiaController@registrar');
Route::get('/garantia/devolucion/comprobante/{id}', 'DevolucionGarantiaController@descargarComprobante');