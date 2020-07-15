<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Marca;
use App\file;
use DB;
use App\Upload;
use JD\Cloudder\Facades\Cloudder;


class MarcaController extends Controller
{
    public function register(Request $request)
    {
        $marca = new Marca();
        $marca->nombre = $request->nombre;

        /*
        if ($request->File('logo')) {
            $file = $request->file('logo');
            $name = time().'.'.$file->getClientOriginalExtension();
            $destination = public_path('Logo_Marca/'); // Se encuentra en la carpeta -> public/Logo_Marca
            $file->move($destination, $name);
            $marca->logo = $name;
          
            Cloudder::upload($name, 
            array (
              " responsive_breakpoints " => 
                array ( 
                  " create_derived " => true , 
                  " bytes_step " => 20000, 
                  " min_width " => 200, 
                  " max_width " => 1000)));
           
        }
        */

        $marca->logo = $request->logo;
        //$marca = Marca::all();
        $marca->save();
        return $marca;

        // Sólo es para la prueba local -> con vista PHP
        
        //$marca = Marca::all();
        //return view('TestCarga.marcas',compact('marca')); 
    }


    public function update(Request $request, $id)
    {
        $marca = Marca::find($id);
        $marca->nombre = $request->nombre;

        if ($request->File('logo')) {
            $file = $request->file('logo');
            $name = time().'.'.$file->getClientOriginalExtension();
            $destination = public_path('Logo_Marcas/'); // Se encuentra en la carpeta -> public/Logo_Marca
            $file->move($destination, $name);
            $marca->logo = $name;
        }

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
    public function formCrear()
    {
        $marca=[];
        return view('TestCarga.crearmarca');
    }

}
