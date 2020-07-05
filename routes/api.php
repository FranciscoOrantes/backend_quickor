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
Route::middleware('jwt.auth:api')->put('/actualizar-proveedor/{id}', 'ProveedorController@update', function (Request $request) {
    return $request->proveedores();
});
Route::middleware('jwt.auth:api')->get('/datos-proveedor/{id}', 'ProveedorController@show', function (Request $request) {
    return $request->proveedores();
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => 'auth.jwt'], function () {
    Route::post('/logout', 'AuthController@logout');
    Route::post('/registro-marca', 'GerenteController@register');

});

