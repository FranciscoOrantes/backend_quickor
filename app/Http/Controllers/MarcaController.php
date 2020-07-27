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
      $marca->logo = $image_url;
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

    public function show(){
        $marcas = Marca::all();
        return $marcas;
    }



    
    
}
