<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Negocios;
class NegociosController extends Controller
{
    public function register(Request $request)
    {

        $negocios = new Negocios();

        $negocios->nombre = $request->nombre;
        $negocios->direccion = $request->direccion;
        $negocios->telefono = $request->telefono;
        $negocios->rfc = $request->rfc;
        $negocios->gerente_id = $request->gerente_id;

        $negocios->save();
        return $negocios;
    }


    public function update(Request $request, $id)
    {
        $negocios = Negocios::find($id);

        $negocios->nombre = $request->nombre;
        $negocios->direccion = $request->direccion;
        $negocios->telefono = $request->telefono;
        $negocios->rfc = $request->rfc;
        $negocios->gerente_id = $request->gerente_id;

        $negocios->update();
        return $negocios;
    }


    public function destroy($id)
    {
        $negocios = Negocios::find($id);
        $negocios->delete();
    }

    public function listaNegocios(){
        
    }
}
