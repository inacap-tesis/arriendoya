<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/catalogo');

/*Route::get('/provincias', 'CatalogoController@seleccionarRegion');
Route::get('/comunas', 'CatalogoController@seleccionarProvincia');
Route::get('/catalogo/filtrar', 'CatalogoController@filtrar');

Route::get('/home', function () {
    return view('home');
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/index', function () {
    return view('index');
});*/

Auth::routes();
