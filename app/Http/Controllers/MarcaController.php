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
        $marca->logo = $request->logo;
        $marca->save();
        /*if ($request->File('logo')) {
            $file = $request->file('logo');
            $name = time().'.'.$file->getClientOriginalExtension();
            $destination = public_path('Logo_Marca/'); // Se encuentra en la carpeta -> public/Logo_Marca
            $file->move($destination, $name);
            $marca->logo = $name;
        }*/

        //$marca->logo = $request->logo;
        
        return $marca;



        // Sólo es para la prueba local -> con vista PHP
       /* $marca = Marca::all();
        return view('TestCarga.marcas',compact('marca')); */
    }


    public function update(Request $request, $id)
    {
        $marca = Marca::find($id);
        $marca->nombre = $request->nombre;
        $marca->logo = $request->logo;
       /* if ($request->File('logo')) {
            $file = $request->file('logo');
            $name = time().'.'.$file->getClientOriginalExtension();
            $destination = public_path('Logo_Marcas/'); // Se encuentra en la carpeta -> public/Logo_Marca
            $file->move($destination, $name);
            $marca->logo = $name;
        }*/

        //$marca->logo = $request->logo;
        $marca->update();
        return $marca;
    }


    public function destroy($id)
    {
        $marca = Marca::find($id);
        $marca->delete();
    }



     // Sólo es para la prueba local -> con vista PHP
    
}
