<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Marca;
class MarcaController extends Controller
{
    public function register(Request $request)
    {
        $marca = new Marca();
        $marca->nombre = $request->nombre;
        $marca->save();


        
        return $marca;



    }


    public function update(Request $request, $id)
    {
        $marca = Marca::find($id);
        $marca->nombre = $request->nombre;
        $marca->update();
        return $marca;
    }


    public function destroy($id)
    {
        $marca = Marca::find($id);
        $marca->delete();
    }
    public function buscar(Request $request){
        $nombre = $request->nombre;
        $query = Marca::select('marca.*')
        ->where('nombre','LIKE','%'.$nombre.'%')
        ->get();
        
        return $query;
    }



     // Sólo es para la prueba local -> con vista PHP
    
}
