<?php

namespace App\Http\Controllers;
use DateTime;
use Illuminate\Http\Request;
use App\Pedidos;
class PedidosController extends Controller
{
    public function register(Request $request)
    {
       $fechaActual = new DateTime();
       $fechaActual->format('d-m-Y');
       $num_pedido_actual =  Pedidos::max('num_pedido');
       if($num_pedido_actual==null){
           $num_pedido_actual=1;
       }else{
           $num_pedido_actual = $num_pedido_actual+1;
       }

       $json = $request->input('json', null);
       $params = json_decode($json);
       $params_array = json_decode($json, true);
        foreach ($params_array AS $param => $paramdata){
            $pedido = new Pedidos();
            $pedido->producto_id = $paramdata['producto_id'];
            $pedido->proveedor_id = $paramdata['proveedor_id'];
            $pedido->gerente_id = $paramdata['gerente_id'];
            $pedido->status = $paramdata['status'];
            $pedido->status_pago = $paramdata['status_pago'];
            $pedido->fecha = $fechaActual;
            $pedido->num_pedido = $num_pedido_actual;
            $pedido->cantidad = $paramdata['cantidad'];
            
            $pedido->save();
       }
    
    }
}
