<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Producto;
use App\Proveedor;
use DB;
use Proveedores;

class ProductoController extends Controller
{
    public function register(Request $request)
    {
        $producto = new Producto();

        $producto->nombre = $request->nombre;
        $producto->presentacion = $request->presentacion;
        $producto->cantidad_presentacion = $request->cantidad_presentacion;
        $producto->tamano_producto = $request->tamano_producto;

        
        if ($request->File('logo')) {
            $file = $request->file('logo');
            $name = time().'.'.$file->getClientOriginalExtension();
            $destination = public_path('Logo_Producto/'); // Se encuentra en la carpeta -> public/Logo_Producto
            $file->move($destination, $name);
            $producto->logo = $name;
        }
        

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

        if ($request->File('logo')) {
            $file = $request->file('logo');
            $name = time().'.'.$file->getClientOriginalExtension();
            $destination = public_path('Logo_Producto/'); // Se encuentra en la carpeta -> public/Logo_Producto
            $file->move($destination, $name);
            $producto->logo = $name;
        }
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


    public function listProducts()
    {
        $id = Auth::id(); // Se obtienen el ID del usuario loggeado
        $idProveedor = DB::table('proveedores')
                 ->select('id')
                 ->where('user_id', $id)
                 ->first()
                 ->id;

        $producto = DB::table('productos')->where('proveedor_id','=',$idProveedor)->get();

        return $producto;

        /*  Así se vería en la sentencia sql
            select * from productos where proveedor_id = 
            (select id from proveedores where user_id = 3)
        */
    }


    // Buscar productos por nombre para el cliente
    public function BuscarProductos(Request $request)
    {
        $nombre = $request->nombre;
        $query = DB::table('productos')
        ->where('nombre','LIKE','%'.$nombre.'%')
        ->get();
        
        return $query;
    }

    // Buscador de productos para el Proveedor
    public function BuscarProductosProveedor(Request $request)
    {
        $id = 1; // el $id Va a ser del proveedor
        $nombre = $request->nombre;

        $query = DB::table('productos')
        ->where('proveedor_id','=',$id)
        ->where('nombre','LIKE','%'.$nombre.'%')
        ->get();
        
        return $query;
    }

    // Filtrar productos por categoria

    // Buscador de proveedores por producto
    public function BuscarProveedores(Request $request)
    {
        $nombre = $request->nombre;
        $query = DB::table('proveedores')
        ->where('nombre','LIKE','%'.$nombre.'%')
        ->get();
        
        return $query;
    }


}
