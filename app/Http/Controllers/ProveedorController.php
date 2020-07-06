<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Proveedor;
use App\User;

class ProveedorController extends Controller
{
    public function register(Request $request) {
        $usuario = new User();
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);
        $usuario->tipo_usuario = $request->tipo_usuario;
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
       
}
