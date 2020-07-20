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
       $params_array = (array)json_decode($json, true);
        foreach ($params_array as $param){
            $pedido = new Pedidos();
            $pedido->producto_id = $param['producto_id'];
            $pedido->proveedor_id = $param['proveedor_id'];
            $pedido->gerente_id = $param['gerente_id'];
            $pedido->status = $param['status'];
            $pedido->status_pago = $param['status_pago'];
            $pedido->fecha = $param['fecha'];
            $pedido->num_pedido = $param['num_pedido'];
            $pedido->cantidad = $param['cantidad'];
            
            $pedido->save();
       }
       $pedidos = Pedidos::all();
       return $pedidos;
    
    }
}
