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
       $contador = 0;
       foreach ($data['datos']['data'] as $key => $value) {
           $contador = $contador+1;
           $pedido = new Pedidos();
            $pedido->producto_id = dd($value[$contador]['producto_id']);
            $pedido->proveedor_id = dd($value[$contador]['proveedor_id']);
            $pedido->gerente_id = dd($value[$contador]['gerente_id']);
            $pedido->status = dd($value[$contador]['status']);
            $pedido->status_pago = dd($value[$contador]['status_pago']);
            $pedido->fecha = dd($value[$contador]['fecha']);
            $pedido->num_pedido = dd($value[$contador]['num_pedido']);
            $pedido->cantidad = dd($value[$contador]['cantidad']);
            
            $pedido->save();
       }
        
       
       $pedidos = Pedidos::all();
       return $pedidos;
    
    }
}
