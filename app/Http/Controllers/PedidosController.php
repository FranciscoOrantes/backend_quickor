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
}
