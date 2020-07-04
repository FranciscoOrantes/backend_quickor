<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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
        return $marca;
    }


    public function update(Request $request, $id)
    {
        $marca = Marca::find($id);

        $marca->nombre = $request->nombre;
        $marca->logo = $request->logo;

        $marca->update();
        return $marca;
    }


    public function destroy($id)
    {
        $marca = Marca::find($id);
        $marca->delete();
    }
    
}
