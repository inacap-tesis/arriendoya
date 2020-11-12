<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Anuncio
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/anuncio/configurar/{inmueble}', 'AnuncioController@configurar');
Route::get('/anuncio/{id}', 'AnuncioController@consultar');
Route::post('/anuncio/activar', 'AnuncioController@activar')->name('publicar'); //RF-INM-06
Route::get('/anuncio/desactivar/{id}', 'AnuncioController@desactivar'); //RF-INM-07