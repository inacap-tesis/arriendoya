<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Antecedente
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/antecedentes', 'AntecedenteController@listar');
Route::get('/antecedentes/{rut}', 'AntecedenteController@listar');
Route::get('/antecedente', 'AntecedenteController@configurar');
Route::post('/antecedente', 'AntecedenteController@registrar');
Route::get('/antecedente/{id}', 'AntecedenteController@descargar');
Route::delete('/antecedente', 'AntecedenteController@eliminar');