<?php

namespace App\Http\Controllers;
use App\firebaseTokens;
use Illuminate\Http\Request;

class firebaseTokensController extends Controller
{
   public function register(Request $request){
    $token = new firebaseTokens();
    $token->user_id = $request->user_id;
    $token->token_firebase = $request->token_firebase;
    $token->save();
       
    $tokens = firebaseTokens::all();
    return $tokens;
   }
   public function show(Request $request){
    $token = firebaseTokens::select('firebase_tokens.token_firebase')
    ->join('users','firebase_tokens.user_id','users.id')
    ->where('users.email','=',$request->email)->get();
    if(sizeof($token)==0){
       return response('status_code',404);
    }else{
      return $token[0];
    }
      
   }
   
   
   
   
}
