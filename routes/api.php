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
Route::middleware('jwt.auth:api')->put('/desactivar-cuenta-proveedor/{id}', 'ProveedorController@desactivarCuenta', function (Request $request) {
    return $request->proveedores();
});

Route::middleware('jwt.auth:api')->put('/desactivar-cuenta-gerente/{id}', 'GerenteController@desactivarCuenta', function (Request $request) {
    return $request->gerente();
});

Route::middleware('jwt.auth:api')->put('/actualizar-proveedor/{id}', 'ProveedorController@update', function (Request $request) {
    return $request->proveedores();
});
Route::middleware('jwt.auth:api')->get('/datos-proveedor/{id}', 'GerenteController@show', function (Request $request) {
    return $request->gerente();
});

Route::middleware('jwt.auth:api')->put('/actualizar-gerente/{id}', 'GerenteController@update', function (Request $request) {
    return $request->gerente();
});
Route::middleware('jwt.auth:api')->get('/datos-gerente/{id}', 'ProveedorController@show', function (Request $request) {
    return $request->proveedores();
});
Route::post('/registro-gerente', 'GerenteController@register');


    // API negocios
Route::middleware('jwt.auth:api')->post('/registro-negocio', 'NegociosController@register');
Route::middleware('jwt.auth:api')->put('/actualizar-negocio/{id}', 'NegociosController@update', function (Request $request) {
        return $request->negocios();
});
Route::middleware('jwt.auth:api')->delete('borrar-negocio/{id}', 'NegociosController@destroy');
//Termina API Negocios

//Api productos
Route::middleware('jwt.auth:api')->post('/registro-producto', 'ProductoController@register');
Route::middleware('jwt.auth:api')->put('/actualizar-producto/{id}', 'ProductoController@update', function (Request $request) {
    return $request->producto();
});
Route::middleware('jwt.auth:api')->delete('borrar-producto/{id}', 'ProductoController@destroy');
Route::middleware('jwt.auth:api')->get('lista-producto/{id}', 'ProductoController@listProducts');

Route::middleware('jwt.auth:api')->get('/buscar-productos/{id}', 'ProductoController@buscarProductos', function (Request $request) {
    return $request->producto();
});
Route::middleware('jwt.auth:api')->get('/buscar-productos-general', 'ProductoController@buscarProductosGeneral', function (Request $request) {
    return $request->producto();
});

Route::middleware('jwt.auth:api')->get('/buscar-productos-categoria', 'ProductoController@filtrarPorCategoria', function (Request $request) {
    return $request->producto();
});
//Termina API productos
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

 //API marcas
Route::middleware('jwt.auth:api')->post('/registro-marca', 'MarcaController@register');
Route::middleware('jwt.auth:api')->put('/actualizar-marca/{id}', 'MarcaController@update', function (Request $request) {
    return $request->marca();
 });
Route::middleware('jwt.auth:api')->delete('borrar-marca/{id}', 'MarcaController@destroy');
Route::group(['middleware' => 'auth.jwt'], function () {
    Route::post('/logout', 'AuthController@logout');
    

});

