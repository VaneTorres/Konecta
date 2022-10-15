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

Route::get('/', 'ProductosController@index');
Route::post('/productos', 'ProductosController@store')->name('productos.store');
Route::post('/producto', 'ProductosController@edit')->name('producto.edit');
Route::delete('/producto/delete', 'ProductosController@destroy')->name('producto.delete');
Route::put('/producto/update', 'ProductosController@update')->name('producto.update');
Route::get('/stock/filtrar', 'ProductosController@filtrarStrock')->name('stock.filtrar');
Route::get('/ventas/filtrar', 'ProductosController@filtrarVentas')->name('ventas.filtrar');
Route::post('/ventas', 'ProductosController@ventas')->name('ventas.index');