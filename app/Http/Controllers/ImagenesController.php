<?php

namespace App\Http\Controllers;

use App\Imagenes;
use App\Imagenes_marcas;
use Illuminate\Http\Request;
use Cloudder;
class ImagenesController extends Controller
{
   public function subirImagenProducto(Request $request,$id){
    $imagen = new Imagenes();
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
       $image->move(public_path("uploads"), $name);
    $imagen ->producto_id=$id;
    $imagen->urlImagen=$image_url;
    $imagen->nombre = $name;
    $imagen->save();

   }

   public function subirImagenMarca(Request $request,$id){
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
       $image->move(public_path("uploads"), $name);
    $imagen ->marca_id=$id;
    $imagen->urlImagen=$image_url;
    $imagen->nombre = $name;
    $imagen->save();

   }
   
}
