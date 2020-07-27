<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Producto;
use App\Proveedor;
use Illuminate\Support\Facades\DB;
use Proveedores;
use App\Http\Controllers\Input;
use Cloudder;
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
        $image_name = $request->file('image_name')->getRealPath();;
        Cloudder::upload($image_name, null);
        list($width, $height) = getimagesize($image_name);

        $image_url= Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height"=>$height]);

       //save to uploads directory
        $producto->logo = $image_url;
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
    public function filtrarPorCategoria(Request $request){
        $producto = Producto::select('productos.*')->where('categoria','=',$request->categoria)->get();
        return $producto;
    }
    
     # yo como cliente quiero un buscador de proveedores por producto
     public function BuscarProveedorProducto(Request $request){

        $nombre = $request->nombre;
        $query = Proveedor::select('proveedores.id','proveedores.nombre', 'proveedores.apellido_paterno',
        'proveedores.apellido_materno','proveedores.telefono','proveedores.direccion', 'proveedores.user_id')
        ->join('productos','productos.proveedor_id','proveedores.id')
        ->where('productos.nombre','LIKE','%'.$nombre.'%')
        ->get();
            
        return $query;
    }

    # Api de buscar productos por proveedor
    public function BuscarProductoPorProveedor(Request $request)
    {
        $nombre = $request->nombre;
        $query = Producto::select('productos.id','productos.nombre', 'productos.presentacion','productos.cantidad_presentacion',
        'productos.tamano_producto','productos.precio','productos.logo', 'productos.marca_id','productos.proveedor_id')
        ->join('proveedores','proveedores.id','productos.proveedor_id')
        ->where('proveedores.nombre','LIKE','%'.$nombre.'%')
        ->get();
            
        return $query;
        
    }

    public function marcasXProveedorCercano(){
        $proveedoresOrdenados = DB::table(DB::raw('proveedors p, negocios n, marcas m, productos r')) 
        ->select(DB::raw("CONCAT('p.nombre',' ','p.apellido_paterno',' ',p.apellido_materno) AS nombreCompleto",'p.id','m.nombre',"(acos(sin(radians(CAST('n.latitud' AS DECIMAL))) * sin(radians(CAST('p.latitud' AS DECIMAL))) + cos(radians(CAST('n.latitud' AS DECIMAL))) *cos(radians(CAST('p.latitud' AS DECIMAL))) * cos(radians(CAST('n.longitud' AS DECIMAL)))-radians(CAST('p.longitud' AS DECIMAL)))*6371) AS distanciaKm"))
        ->where('n.id', '=', 11)
        ->where('r.marca_id','=', 'm.id')
        ->groupByRaw('p.id,m.nombre,nombreCompleto,distanciaKm')
        ->orderBy('distanciaKm', 'asc')->get();
         return $proveedoresOrdenados;
    }

   

    

    
}
