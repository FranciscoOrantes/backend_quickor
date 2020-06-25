<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Proveedor;
use App\User;

class ProveedorController extends Controller
{
    public function register(Request $request) {
        $proveedor = new Proveedor();
        $proveedor->nombre = $request->nombre;
        $proveedor->apellido_paterno = $request->apellido_paterno;
        $proveedor->apellido_materno = $request->apellido_materno;
        $proveedor->marca = $request->marca;
        $proveedor->telefono = $request->telefono;
        $proveedor->direccion = $request->direccion;
        $proveedor->correo = $request->correo;
        $proveedor->password = bcrypt($request->password);
        $proveedor->save();
        $usuario = new User();
        $usuario->name = $request->nombre;
        $usuario->email = $request->correo;
        $usuario->password = bcrypt($request->password);
        $usuario->save();
    }
       
}
