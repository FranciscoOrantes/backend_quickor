<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\notificaciones;
class notificacionesController extends Controller
{
    public function register(Request $request){
        $token = new notificaciones();
        $token->user_id = $request->user_id;
        $token->token_firebase = $request->notificacion;
        $token->save();
           
        $tokens = notificaciones::all();
        return $tokens;
       }
       public function show($id){
        $token = notificaciones::find($id);
        return $token;   
       }

    public function realizarNotificacion(){
        //FIREBASE
    }   
}
