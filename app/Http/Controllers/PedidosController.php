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
        foreach ($request->all() as $req){
            $pedido = new Pedidos();
            $pedido->producto_id = $req['producto_id'];
            $pedido->proveedor_id = $req['proveedor_id'];
            $pedido->gerente_id = $req['gerente_id'];
            $pedido->status = $req['status'];
            $pedido->status_pago = $req['status_pago'];
            $pedido->fecha = $fechaActual;
            $pedido->num_pedido = $num_pedido_actual;
            $pedido->save();
       }
    
    }
}
