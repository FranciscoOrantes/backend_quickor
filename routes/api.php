<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', 'LoginController@login');
Route::post('/registro-proveedor', 'ProveedorController@register');
Route::post('/registro-gerente', 'GerenteController@register');



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'jwt.auth'], function () { // Antes era:  auth.jwt

    Route::post('/logout', 'AuthController@logout');

    // API negocios
    Route::middleware('jwt.auth:api')->put('/actualizar-negocio/{id}', 'NegociosController@update', function (Request $request) {
        return $request->negocios();
    });
    Route::middleware('jwt.auth:api')->delete('borrar-negocio/{id}', 'NegociosController@destroy');


    // API de productos
    Route::middleware('jwt.auth:api')->put('/actualizar-producto/{id}', 'ProductoController@update', function (Request $request) {
        return $request->producto();
    });
    Route::middleware('jwt.auth:api')->delete('borrar-producto/{id}', 'ProductoController@destroy');

    //API marcas
    Route::middleware('jwt.auth:api')->put('/actualizar-marca/{id}', 'MarcaController@update', function (Request $request) {
        return $request->marca();
    });
    Route::middleware('jwt.auth:api')->delete('borrar-marca/{id}', 'MarcaController@destroy');
});


// API de negocios
Route::post('/registro-negocio', 'NegociosController@register');

// API de Productos
Route::post('/registro-producto', 'ProductoController@register');

// API de Marcas
Route::post('/registro-marca', 'MarcaController@register');
