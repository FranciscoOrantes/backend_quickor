<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Producto;
use App\Proveedor;
use DB;
use Proveedores;
use App\Http\Controllers\Input;
class ProductoController extends Controller
{
    public function register(Request $request)
    {
        $producto = new Producto();

        $producto->nombre = $request->nombre;
        $producto->presentacion = $request->presentacion;
        $producto->cantidad_presentacion = $request->cantidad_presentacion;
        $producto->tamano_producto = $request->tamano_producto;
        $producto->categoria = $request->categoria;
        $producto->logo = $request->logo;
        
       /* if ($request->File('logo')) {
            $file = $request->file('logo');
            $name = time().'.'.$file->getClientOriginalExtension();
            $destination = public_path('Logo_Producto/'); // Se encuentra en la carpeta -> public/Logo_Producto
            $file->move($destination, $name);
            $producto->logo = $name;
        }*/
        

        //$producto->logo = $request->logo;
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
        $producto->categoria = $request->categoria;
        $producto->logo = $request->logo;
        /*if ($request->File('logo')) {
            $file = $request->file('logo');
            $name = time().'.'.$file->getClientOriginalExtension();
            $destination = public_path('Logo_Producto/'); // Se encuentra en la carpeta -> public/Logo_Producto
            $file->move($destination, $name);
            $producto->logo = $name;
        }*/
        //$producto->logo = $request->logo;
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


    public function listProducts($id)
    {
         // Se obtienen el ID del usuario loggeado
        

        $producto = Producto::select('productos.*')->where('proveedor_id','=',$id)->get();

        return $producto;

        /*  Así se vería en la sentencia sql
            select * from productos where proveedor_id = 
            (select id from proveedores where user_id = 3)
        */
    }
    public function buscarProductos(Request $request,$id){
      
        $producto = Producto::select('productos.*')->where('nombre','like',"%$request->nombre%")->where('productos.proveedor_id','=',$id)->get();
        return $producto;
    }
    public function buscarProductosGeneral(Request $request){
        $producto = Producto::select('productos.*')->where('nombre','like',"%$request->nombre%")->get();
        return $producto;

    }
}
