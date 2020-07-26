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
   public function show($id){
    $token = firebaseTokens::select('firebase_tokens.token_firebase')
    ->where('user_id','=',$id)->get();
    if($token[0]==null){
       return response('status_code',404);
    }else{
      return response()->json([
         'token_firebae' => $token[0],
         ], 200);
    }
      
   }
   
   
   
   
}
