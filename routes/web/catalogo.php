<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Catálogo
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/catalogo', 'CatalogoController@cargar');
Route::get('/catalogo/filtrar', 'CatalogoController@filtrar');
Route::get('/catalogo/ordenar/precio/mayor', 'CatalogoController@ordenarordenarPrecioMayor');
Route::get('/catalogo/ordenar/precio/menor', 'CatalogoController@ordenarPrecioMenor');
Route::get('/catalogo/ordenar/fecha/mayor', 'CatalogoController@ordenarFechaMayor');
Route::get('/catalogo/ordenar/fecha/menor', 'CatalogoController@ordenarFechaMenor');
Route::get('/provincias', 'CatalogoController@seleccionarRegion');
Route::get('/comunas', 'CatalogoController@seleccionarProvincia');