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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hol', function () {
    return view('TestCarga.canciones');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// Sólo es para la prueba de la carga del logo
//Route::post('registro-marca', 'MarcaController@register'); 
//Route::get('crear-marca','MarcaController@formCrear');