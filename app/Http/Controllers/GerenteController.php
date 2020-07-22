<?php

namespace App\Http\Controllers;
use App\Mail\Registro;
use App\Mail\DesactivarCuenta;
use App\Mail\CambiarPassword;
use Illuminate\Http\Request;
use App\Gerente;
use App\User;
use Mail;
use Illuminate\Support\Facades\Log;
class GerenteController extends Controller
{
    public function register(Request $request) {
        $usuario = new User();
        #0 ES ACTIVO, 1 ES INACTIVO
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);
        $usuario->tipo_usuario = $request->tipo_usuario;
        $usuario->status = 0;
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
    public function desactivarCuenta($id){
        $email = User::select('users.email')
        ->join('gerentes','users.id','=','gerentes.user_id')
        ->where('gerentes.user_id', $id)->get();        
        $usuario = User::find($id);
        $usuario->status = 1;
        $usuario->update();
        Log::info('Se ha desactivado la cuenta de: '.$email);
        Mail::to($email)->send(new DesactivarCuenta($_SERVER['REMOTE_ADDR']));
        return $usuario;  
    }

   
}
