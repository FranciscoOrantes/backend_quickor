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

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::post('/logout', 'AuthController@logout');
});


// CRUD de negocios
Route::post('/registro-negocio', 'NegociosController@register');
Route::middleware('auth:api')->put('/actualizar-negocio/{id}','NegociosController@update', function (Request $request) {
    return $request->negocios();
});
Route::middleware('auth:api')->delete('delete-negocio/{id}','NegociosController@delete');