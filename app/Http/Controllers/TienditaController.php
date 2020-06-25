<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\RegisterAuthRequest;
use App\Distribuidora;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
class TienditaController extends Controller
{
    public function register(Request $request) {
        $distribuidora = new Distribuidora();
        $distribuidora->nombre = $request->nombre;
        $distribuidora->apellido_paterno = $request->apellido_paterno;
        $distribuidora->apellido_materno = $request->apellido_materno;
        $distribuidora->nombre_tienda = $request->nombre_tienda;
        $distribuidora->telefono = $request->telefono;
        $distribuidora->direccion = $request->direccion;
        $distribuidora->correo = $request->correo;
        $distribuidora->password = bcrypt($request->password);
        $distribuidora->save();
        $usuario = new User();
        $usuario->name = $request->nombre;
        $usuario->email = $request->correo;
        $usuario->password = bcrypt($request->password);
        $usuario->save();
    }
}
