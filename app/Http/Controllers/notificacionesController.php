<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\notificaciones;
use App\firebaseTokens;
use App\Producto;
use fcm;
use App\User;
class notificacionesController extends Controller
{
    public function register(Request $request){
        $notificacion = new notificaciones();
        $notificacion->user_id = $request->user_id;
        $notificacion->notificacion = $request->notificacion;
        $notificacion->save();
           
        $notificacion = notificaciones::all();
        return $notificacion;
       }
       public function show($id){
        $notificacion = notificaciones::find($id);
        return $notificacion;   
       }

    
    
    public function enviarNotificacion(Request $request,$id)
{
    
    
    $url_producto = Producto::select('logo')
    ->where('id','=',$request->producto_id)
    ->get();
    $recipients = firebaseTokens::select('firebase_tokens.token_firebase')
    ->where('user_id','=',$id)
    ->pluck('token_firebase')->toArray();
   
    print_r($recipients);
    fcm()
        ->to($recipients)
        ->notification([
            'title' => 'Tienes un nuevo Pedido!',
            'body' => 'Haz click aqui para ver las notificaciones'
        ])
        ->send();
        $notificacion = new notificaciones();
        $notificacion->user_id = $request->user_id;
        $notificacion->pedido = 'PEDIDO EN PRODUCTO: '.$request->pedido;
        $notificacion->url_producto = $url_producto[0]['logo'];
        $notificacion->status = $request->status;
        $notificacion->total = 'TOTAL: $'.$request->total;
        $notificacion->save();
           
        $notificacion = notificaciones::all();
        return $notificacion;    
}
public function obtenerListaNotificaciones(Request $request){
$id = User::select('id')
->where('email','=',$request->email)->get();
$notificaciones= notificaciones::select('notificaciones.*')
->where('user_id','=',$id[0]['id'])
->orderBy('id', 'DESC')
->take(10)
->get();

return response()->json([
    'notificaciones' => $notificaciones,
    ]);
}
}
