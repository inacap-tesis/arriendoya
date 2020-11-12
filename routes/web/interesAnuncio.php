<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Interés Anuncio
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/interesados/{anuncio}', 'InteresController@listar'); //RF-INM-08
Route::post('/interes', 'InteresController@registrar'); //RF-PRE-06
Route::delete('/interes', 'InteresController@eliminar'); //RF-PRE-03 & RF-PRE-07
Route::post('/interes/candidatos', 'InteresController@definirCandidatos'); //RF-PRE-01