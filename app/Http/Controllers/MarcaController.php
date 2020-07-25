<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Marca;
use App\Imagenes_marcas;
use Cloudder;
class MarcaController extends Controller
{
    public function register(Request $request)
    {
        $marca = new Marca();
        $marca->nombre = $request->nombre;
        $marca->save();
        $id = $marca->id;
        $imagen = new Imagenes_marcas();
    $this->validate($request,[
        'image_name'=>'required|mimes:jpeg,bmp,jpg,png|between:1, 6000',
    ]);

    $image = $request->file('image_name');

    $name = $request->file('image_name')->getClientOriginalName();

    $image_name = $request->file('image_name')->getRealPath();;
    Cloudder::upload($image_name, null);
    list($width, $height) = getimagesize($image_name);

       $image_url= Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height"=>$height]);

       //save to uploads directory
      
    $imagen ->marca_id=$id;
    $imagen->urlImagen=$image_url;
    $imagen->nombre = $name;
    $imagen->save();
        
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
