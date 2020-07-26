<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\notificaciones;
use App\firebaseTokens;
use Fcm;
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
    $token = firebaseTokens::select('firebaseTokens.token_firebase')
    ->where('firebaseTokens.user_id','=',$id)->first()->toArray();
    
    fcm()
        ->to($token)
        ->notification([
            'title' => $request->title,
            'body' => $request->body
        ])
        ->send();
}
}
