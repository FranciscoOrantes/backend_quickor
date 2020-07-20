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
            $pedido->producto_id = dd($key['producto_id']);
            $pedido->proveedor_id = dd($key['proveedor_id']);
            $pedido->gerente_id = dd($key['gerente_id']);
            $pedido->status = dd($key['status']);
            $pedido->status_pago = dd($key['status_pago']);
            $pedido->fecha = dd($key['fecha']);
            $pedido->num_pedido = dd($key['num_pedido']);
            $pedido->cantidad = dd($key['cantidad']);
            
            $pedido->save();
       }
        
       
       $pedidos = Pedidos::all();
       return $pedidos;
    
    }
}
