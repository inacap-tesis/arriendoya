<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Cuenta Bancaria
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/cuenta', 'CuentaBancariaController@configurar');
Route::post('/cuenta', 'CuentaBancariaController@registrar');
Route::put('/cuenta', 'CuentaBancariaController@modificar');