<?php

namespace App\Http\Controllers;
use DateTime;
use Illuminate\Http\Request;
use App\Pedidos;
class PedidosController extends Controller
{
    public function register(Request $request)
    {
        $json = request()->all();
       $fechaActual = new DateTime();
       $fechaActual->format('d-m-Y');
      $num_pedido_actual =  Pedidos::max('num_pedido');
       if($num_pedido_actual==null){
           $num_pedido_actual=1;
       }else{
           $num_pedido_actual = $num_pedido_actual+1;
       }
    
        
       for ($i=0; $i <sizeof($json) ; $i++) { 
        $pedido = new Pedidos();
        $pedido->producto_id = $json[$i]['producto_id'];
        $pedido->proveedor_id = $json[$i]['proveedor_id'];
        $pedido->gerente_id = $json[$i]['gerente_id'];
        $pedido->status = $json[$i]['status'];
        $pedido->status_pago = $json[$i]['status_pago'];
        $pedido->fecha = $fechaActual;
        $pedido->num_pedido = $num_pedido_actual;
        $pedido->cantidad = $json[$i]['cantidad'];
        
        $pedido->save();
       }
       $pedidos = Pedidos::all();
       return $pedidos;
    }

    public function registrarPedidos(Request $request){
        //status 0: En progreso
        //status 1: Finalizado
        //status 2: Cancelado
        $num_pedido_actual =  Pedidos::max('num_pedido');
        if($num_pedido_actual==null){
            $num_pedido_actual=1;
        }else{
            $num_pedido_actual = $num_pedido_actual+1;
        }
        $pedido = new Pedidos();
        $pedido->producto_id = $request->producto_id;
        $pedido->proveedor_id = $request->proveedor_id;
        $pedido->gerente_id = $request->gerente_id;
        $pedido->status = '0';
        $pedido->status_pago = $request->status_pago;
        $pedido->fecha =$request->fechaActual;
        $pedido->num_pedido = $num_pedido_actual;
        $pedido->cantidad = $request->cantidad;
        
        $pedido->save();
       
       $pedidos = Pedidos::all();
       return $pedidos;
    }
    //PENDIENTES
    public function listaPedidosDelGerente($id){
    $pedidos = Pedidos::select('pedidos.*','proveedors.nombre','proveedors.apellido_paterno','proveedors.apellido_materno','productos.nombre','productos.presentacion','productos.marca_id','marcas.nombre')
    ->join('proveedors','proveedors.id','pedidos.proveedor_id')
    ->join('productos','productos.id','pedidos.producto_id')
    ->join('marcas','marcas.id','productos.marca_id')
    ->where('pedidos.status','=','0')
    ->where('pedidos.gerente_id','=',$id)
    ->get();
    return $pedidos;
}
    //PENDIENTES
    public function listaPedidosDelProveedor($id){
        $pedidos = Pedidos::select('pedidos.*','gerentes.nombre','gerentes.apellido_paterno','gerentes.apellido_materno','productos.nombre','productos.presentacion','productos.marca_id','marcas.nombre')
        ->join('gerentes','gerentes.id','pedidos.gerente_id')
        ->join('productos','productos.id','pedidos.producto_id')
        ->join('marcas','marcas.id','productos.marca_id')
        ->where('pedidos.status','=','0')
        ->where('pedidos.proveedor_id','=',$id)
        ->get();
        return $pedidos;
    }
    public function listaPedidosFinalizadosDelGerente($id){
        $pedidos = Pedidos::select('pedidos.*','proveedors.nombre','proveedors.apellido_paterno','proveedors.apellido_materno','productos.nombre','productos.presentacion','productos.marca_id','marcas.nombre')
        ->join('proveedors','proveedors.id','pedidos.proveedor_id')
        ->join('productos','productos.id','pedidos.producto_id')
        ->join('marcas','marcas.id','productos.marca_id')
        ->where('pedidos.status','=','1')
        ->where('pedidos.gerente_id','=',$id)
        ->get();
        return $pedidos;
    }
    //FINALIZADOS
    public function listaPedidosFinalizadosDelProveedor($id){
        $pedidos = Pedidos::select('pedidos.*','gerentes.nombre','gerentes.apellido_paterno','gerentes.apellido_materno','productos.nombre','productos.presentacion','productos.marca_id','marcas.nombre')
        ->join('gerentes','gerentes.id','pedidos.gerente_id')
        ->join('productos','productos.id','pedidos.producto_id')
        ->join('marcas','marcas.id','productos.marca_id')
        ->where('pedidos.status','=','1')
        ->where('pedidos.proveedor_id','=',$id)
        ->get();
        return $pedidos;
    }
}
