<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Producto;

class ProductoController extends Controller
{
    public function register(Request $request)
    {
        $producto = new Producto();

        $producto->nombre = $request->nombre;
        $producto->presentacion = $request->presentacion;
        $producto->cantidad_presentacion = $request->cantidad_presentacion;
        $producto->tamano_producto = $request->tamano_producto;
        $producto->logo = $request->logo;
        $producto->precio = $request->precio;
        $producto->marca_id = $request->marca_id;
        $producto->proveedor_id = $request->proveedor_id;

        $producto->save();
        return $producto;
    }


    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);

        $producto->nombre = $request->nombre;
        $producto->presentacion = $request->presentacion;
        $producto->cantidad_presentacion = $request->cantidad_presentacion;
        $producto->tamano_producto = $request->tamano_producto;
        $producto->logo = $request->logo;
        $producto->precio = $request->precio;
        $producto->marca_id = $request->marca_id;
        $producto->proveedor_id = $request->proveedor_id;

        $producto->update();
        return $producto;
    }


    public function destroy($id)
    {
        $producto = Producto::find($id);
        $producto->delete();
    }
}
