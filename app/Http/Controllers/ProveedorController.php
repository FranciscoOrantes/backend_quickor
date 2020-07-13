<?php

namespace App\Http\Controllers;

use App\Mail\DesactivarCuenta;
use Illuminate\Http\Request;
use App\Mail\Registro;
use App\Proveedor;
use App\User;
use Mail;
class ProveedorController extends Controller
{
    public function register(Request $request) {
        $usuario = new User();
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);
        $usuario->tipo_usuario = $request->tipo_usuario;
        $usuario->status = 0;
        $usuario->save();
        $id = $usuario->id;
        printf($id);
        $proveedor = new Proveedor();
        $proveedor->nombre = $request->nombre;
        $proveedor->apellido_paterno = $request->apellido_paterno;
        $proveedor->apellido_materno = $request->apellido_materno;
        $proveedor->telefono = $request->telefono;
        $proveedor->direccion = $request->direccion;
        $proveedor->user_id = $id;
        $proveedor->save();
        Mail::to($request->email)->send(new Registro($_SERVER['REMOTE_ADDR']));
        
    }
    public function update(Request $request,$id){
        $proveedor = Proveedor::find($id);
        $proveedor->nombre = $request->nombre;
        $proveedor->apellido_paterno = $request->apellido_paterno;
        $proveedor->apellido_materno = $request->apellido_materno;
        $proveedor->telefono = $request->telefono;
        $proveedor->direccion = $request->direccion;
        $proveedor->update();
        return $proveedor;
    }
    public function show($id){
        $proveedor = Proveedor::find($id);
        return $proveedor;
    }
    public function desactivarCuenta($id){
        
        $idUsuario = User::select('users.id')
                ->join('proveedors','users.id','=','proveedors.user_id')
                ->where('proveedors.user_id', $id)->first()->toArray();
        $email = User::select('users.email')
        ->join('proveedors','users.id','=','proveedors.user_id')
        ->where('proveedors.user_id', $id)->first()->toArray();        
        $usuario = User::find($idUsuario);
        $usuario->status = 1;
        $usuario->update();
        Mail::to($email)->send(new DesactivarCuenta($_SERVER['REMOTE_ADDR']));
        return $usuario;        

        #priuenafsddf        
    }
       
}
