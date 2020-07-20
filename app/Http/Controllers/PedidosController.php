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
       $data = request()->all();
       foreach ($data['datos']['data'] as $key => $value) {
           $pedido = new Pedidos();
            $pedido->producto_id = dd($value['producto_id']);
            $pedido->proveedor_id = dd($value['proveedor_id']);
            $pedido->gerente_id = dd($value['gerente_id']);
            $pedido->status = dd($value['status']);
            $pedido->status_pago = dd($value['status_pago']);
            $pedido->fecha = dd($value['fecha']);
            $pedido->num_pedido = dd($value['num_pedido']);
            $pedido->cantidad = dd($value['cantidad']);
            
            $pedido->save();
       }
        
       
       $pedidos = Pedidos::all();
       return $pedidos;
    
    }
}
