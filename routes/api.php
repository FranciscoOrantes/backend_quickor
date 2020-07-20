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
    Route::middleware('jwt.auth:api')->post('/registro-negocio', 'NegociosController@register');
    Route::middleware('jwt.auth:api')->put('/actualizar-negocio/{id}', 'NegociosController@update', function (Request $request) {
        return $request->negocios();
    });
    Route::middleware('jwt.auth:api')->delete('borrar-negocio/{id}', 'NegociosController@destroy');
    // --- Lo acabo de agregar ---
    Route::middleware('jwt.auth:api')->post('/buscar-negocios', 'NegociosController@BuscarProveedorNegocio');


    // API de productos
    Route::middleware('jwt.auth:api')->post('/registro-producto', 'ProductoController@register');
    Route::middleware('jwt.auth:api')->put('/actualizar-producto/{id}', 'ProductoController@update', function (Request $request) {
        return $request->producto();
    });

    Route::middleware('jwt.auth:api')->delete('borrar-producto/{id}', 'ProductoController@destroy');
    Route::middleware('jwt.auth:api')->get('lista-producto', 'ProductoController@listProducts');
    Route::middleware('jwt.auth:api')->post('buscar-producto', 'ProductoController@BuscarProductos');
    Route::middleware('jwt.auth:api')->post('buscar-producto-proveedor', 'ProductoController@BuscarProductosProveedor');
    // - - -  Lo acabo de agregar - - -
    Route::middleware('jwt.auth:api')->post('/buscar-proveedor-producto', 'ProductoController@BuscarProveedorProducto');
    Route::middleware('jwt.auth:api')->post('/buscar-producto-por-proveedor', 'ProductoController@BuscarProductoPorProveedor');
    
    
    //API marcas
    Route::middleware('jwt.auth:api')->post('/registro-marca', 'MarcaController@register');
    Route::middleware('jwt.auth:api')->put('/actualizar-marca/{id}', 'MarcaController@update', function (Request $request) {
        return $request->marca();
    });
    Route::middleware('jwt.auth:api')->delete('borrar-marca/{id}', 'MarcaController@destroy');


    // API de Contactos
    Route::middleware('jwt.auth:api')->post('/agregar-contacto', 'ContactosController@register');
    Route::middleware('jwt.auth:api')->delete('borrar-contacto/{id}', 'ContactosController@destroy');
    Route::middleware('jwt.auth:api')->post('/lista-contactos-gerente', 'ContactosController@ListaContactosGerente');
    Route::middleware('jwt.auth:api')->get('/lista-contactos-proveedor', 'ContactosController@ListaContactosProveedores');
       


});