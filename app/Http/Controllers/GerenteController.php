<?php

namespace App\Http\Controllers;
use App\Mail\Registro;
use Illuminate\Http\Request;
use App\Gerente;
use App\User;
use Mail;
class GerenteController extends Controller
{
    public function register(Request $request) {
        $usuario = new User();
        
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);
        $usuario->tipo_usuario = $request->tipo_usuario;
        $usuario->save();
        $id = $usuario->id;
        printf($id);
        $proveedor = new Gerente();
        $proveedor->nombre = $request->nombre;
        $proveedor->apellido_paterno = $request->apellido_paterno;
        $proveedor->apellido_materno = $request->apellido_materno;
        $proveedor->user_id = $id;
        $proveedor->save();   
        Mail::to($request->email)->send(new Registro($_SERVER['REMOTE_ADDR']));   
    }
    public function update(Request $request,$id){
        $gerente = Gerente::find($id);
        $gerente->nombre = $request->nombre;
        $gerente->apellido_paterno = $request->apellido_paterno;
        $gerente->apellido_materno = $request->apellido_materno;
        $gerente->update();
        return $gerente;
    }
    public function show($id){
        $gerente = Gerente::find($id);
        return $gerente;
    }
}
