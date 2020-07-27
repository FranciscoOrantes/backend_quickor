<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\notificaciones;
use App\firebaseTokens;
use fcm;
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
    $recipients = firebaseTokens::select('firebase_tokens.token_firebase')
    ->where('user_id','=',$id)
    ->pluck('token_firebase')->toArray();
   
    print_r($recipients);
    fcm()
        ->to($recipients)
        ->notification([
            'title' => $request->title,
            'body' => $request->body
        ])
        ->send();
        $notificacion = new notificaciones();
        $notificacion->user_id = $request->user_id;
        $notificacion->title = $request->title;
        $notificacion->body = $request->body;
        $notificacion->tipo = $request->tipo;
        $notificacion->save();
           
        $notificacion = notificaciones::all();
        return $notificacion;    
}
}
