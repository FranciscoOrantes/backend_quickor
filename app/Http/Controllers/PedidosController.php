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
           printf(dd($value['status']));
       }
        /*foreach ($params_array as $param){
            print('DATOS ' + $param['status']);
           
            /* $pedido = new Pedidos();
            $pedido->producto_id = dd($paramdata['producto_id']);
            $pedido->proveedor_id = dd($paramdata['proveedor_id']);
            $pedido->gerente_id = dd($paramdata['gerente_id']);
            $pedido->status = dd($paramdata['status']);
            $pedido->status_pago = dd($paramdata['status_pago']);
            $pedido->fecha = dd($paramdata['fecha']);
            $pedido->num_pedido = dd($paramdata['num_pedido']);
            $pedido->cantidad = dd($paramdata['cantidad']);
            
            $pedido->save();*/
       
       $pedidos = Pedidos::all();
       return $data;
    
    }
}
