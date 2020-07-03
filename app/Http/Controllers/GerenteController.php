<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gerente;
use App\User;

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
        
    }
}
