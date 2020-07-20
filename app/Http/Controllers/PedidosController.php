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
       $json = $request->input('json', null);
       $params = json_decode($json);
       $params_array = (array)json_decode($json, true);
        foreach ($data as $param => $paramdata){
            $pedido = new Pedidos();
            $pedido->producto_id = dd($paramdata['producto_id']);
            $pedido->proveedor_id = dd($paramdata['proveedor_id']);
            $pedido->gerente_id = dd($paramdata['gerente_id']);
            $pedido->status = dd($paramdata['status']);
            $pedido->status_pago = dd($paramdata['status_pago']);
            $pedido->fecha = dd($paramdata['fecha']);
            $pedido->num_pedido = dd($paramdata['num_pedido']);
            $pedido->cantidad = dd($paramdata['cantidad']);
            
            $pedido->save();
       }
       $pedidos = Pedidos::all();
       return $pedidos;
    
    }
}
