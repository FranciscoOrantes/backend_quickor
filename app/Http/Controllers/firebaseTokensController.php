<?php

namespace App\Http\Controllers;
use App\firebaseTokens;
use Illuminate\Http\Request;
use Crypt;
class firebaseTokensController extends Controller
{
   public function register(Request $request){
    $token = new firebaseTokens();
    $token->user_id = $request->user_id;
    $token->token_firebase = Crypt::encrypt($request->token_firebase);
    $token->save();
       
    $tokens = firebaseTokens::all();
    return $tokens;
   }
   public function show($id){
    $token = firebaseTokens::find($id);
    return $token;   
   }
   
   
   
   
}
