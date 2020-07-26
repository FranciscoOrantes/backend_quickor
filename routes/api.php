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
Route::put('/actualizar-status/{id}', 'LoginController@actualizarStatus');
Route::post('/registro-proveedor', 'ProveedorController@register');
Route::middleware('jwt.auth:api')->put('/desactivar-cuenta-proveedor/{id}', 'ProveedorController@desactivarCuenta', function (Request $request) {
    return $request->proveedores();
});
Route::post('/solicitar-cambio', 'LoginController@solicitarCambioPassword');
Route::put('/actualizar-password', 'LoginController@actualizarPassword');
Route::post('/solicitar-activacion', 'LoginController@solicitarActivacion');


Route::middleware('jwt.auth:api')->put('/desactivar-cuenta/{id}', 'LoginController@desactivarCuenta', function (Request $request) {
    return $request->gerente();
});

Route::middleware('jwt.auth:api')->put('/actualizar-proveedor/{id}', 'ProveedorController@update', function (Request $request) {
    return $request->proveedores();
});
Route::middleware('jwt.auth:api')->get('/datos-proveedor/{id}', 'ProveedorController@show', function (Request $request) {
    return $request->proveedor();
});

Route::middleware('jwt.auth:api')->put('/actualizar-gerente/{id}', 'GerenteController@update', function (Request $request) {
    return $request->gerente();
});
Route::middleware('jwt.auth:api')->get('/datos-gerente/{id}', 'GerenteController@show', function (Request $request) {
    return $request->gerente();
});
Route::post('/registro-gerente', 'GerenteController@register');


    // API negocios
Route::middleware('jwt.auth:api')->post('/registro-negocio', 'NegociosController@register');
Route::middleware('jwt.auth:api')->put('/actualizar-negocio/{id}', 'NegociosController@update', function (Request $request) {
        return $request->negocios();
});
Route::middleware('jwt.auth:api')->delete('borrar-negocio/{id}', 'NegociosController@destroy');
Route::middleware('jwt.auth:api')->get('datos-negocio/{id}', 'NegociosController@show');

// --- Lo acabo de agregar ---
Route::middleware('jwt.auth:api')->post('/buscar-negocios', 'NegociosController@BuscarProveedorNegocio');

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

Route::middleware('jwt.auth:api')->post('/buscar-proveedor-producto', 'ProductoController@BuscarProveedorProducto');
    Route::middleware('jwt.auth:api')->post('/buscar-producto-por-proveedor', 'ProductoController@BuscarProductoPorProveedor');
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
Route::middleware('jwt.auth:api')->get('/buscar-marca', 'MarcaController@buscar');
//API PEDIDOS
Route::middleware('jwt.auth:api')->post('/registrar-pedido', 'PedidosController@register', function (Request $request) {
    return $request->marca();
 });

 //Route::post('/registrar-pedidoprueba', 'PedidosController@register');
Route::get('/paypal/pay', 'PaypalController@payWithPayPal');
Route::get('/paypal/status', 'PaypalController@payPalStatus');


//API CONTACTOS
Route::middleware('jwt.auth:api')->post('/agregar-contacto', 'ContactosController@register');
Route::middleware('jwt.auth:api')->delete('borrar-contacto/{id}', 'ContactosController@destroy');
Route::middleware('jwt.auth:api')->get('/lista-contactos-gerente/{id}', 'ContactosController@ListaContactosGerente');
Route::middleware('jwt.auth:api')->get('/lista-contactos-proveedor/{id}', 'ContactosController@ListaContactosProveedores');
Route::middleware('jwt.auth:api')->post('/buscar-contactos-gerente/{id}', 'ContactosController@buscarNombreContactosDelGerente');
Route::middleware('jwt.auth:api')->post('/buscar-contactos-proveedor/{id}', 'ContactosController@buscarNombreContactosDelProveedor');
    
//API PEDIDOS
Route::middleware('jwt.auth:api')->post('/realizar-pedido', 'PedidosController@registrarPedidos');
Route::middleware('jwt.auth:api')->get('/pedidos-proceso-gerente/{id}', 'PedidosController@listaPedidosDelGerente');
Route::middleware('jwt.auth:api')->get('/pedidos-proceso-proveedor/{id}', 'PedidosController@listaPedidosDelProveedor');
Route::middleware('jwt.auth:api')->get('/pedidos-finalizados-gerente/{id}', 'PedidosController@listaPedidosFinalizadosDelGerente');
Route::middleware('jwt.auth:api')->get('/pedidos-finalizados-proveedor/{id}', 'PedidosController@listaPedidosFinalizadosDelProveedor');



//NOTIFICACIONES Y TOKENS
Route::middleware('jwt.auth:api')->post('/registrar-token', 'firebaseTokensController@register');
Route::middleware('jwt.auth:api')->get('/obtener-token/{id}', 'firebaseTokensController@show');
Route::middleware('jwt.auth:api')->post('/realizar-notificacion/{id}', 'notificacionesController@enviarNotificacion');