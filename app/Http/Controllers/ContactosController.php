<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contactos;
use DB;
use Facade\Ignition\QueryRecorder\Query;
use PhpOption\None;

class ContactosController extends Controller
{
    public function register(Request $request)
    {
        $contacto = new Contactos();
        $contacto->gerente_id = $request->gerente_id;
        $contacto->proveedor_id = $request->proveedor_id;

        $contacto->save();
        return $contacto;
    }

    
    public function destroy($id)
    {
        $contacto = Contactos::find($id);
        $contacto->delete();

    }

    public $nombre;
    public function ListaContactosGerente()
    {
        $id = 1; #El id sería del gerente que quiere ver la lista de sus proveedores 
        $nombre = $this->nombre;
        #echo($this->nombre);

        $query = DB::table('proveedores')
        ->join('contactos','contactos.proveedor_id','proveedores.id')
        ->join('gerentes','gerentes.id','contactos.gerente_id')
        ->select('proveedores.id','proveedores.nombre','proveedores.apellido_paterno', 
        'proveedores.apellido_materno','proveedores.telefono','proveedores.direccion','proveedores.user_id')
        ->where('gerentes.id','=',$id)
        ->where('proveedores.nombre','LIKE','%'.$nombre.'%')
        ->get();
        return $query;
    }


    public function ListaContactosProveedores()
    {
        $id = 1; #El id sería del proveedor que quiere ver la lista de sus clientes
        $nombre = $this->nombre;

        $query = DB::table('gerentes')
        ->join('contactos','contactos.gerente_id','gerentes.id')
        ->join('proveedores','proveedores.id','contactos.proveedor_id')
        ->select('gerentes.id','gerentes.nombre','gerentes.apellido_paterno','gerentes.apellido_materno','gerentes.user_id')
        ->where('proveedores.id','=',$id)
        ->where('gerentes.nombre','LIKE','%'.$nombre.'%')
        ->get();
        return $query;
    }

    
    // Para buscar contactos de gerentes y proveedores
    public function BuscarContactoGerente(Request $request)
    {        
        $this->nombre = $request->nombre;
        return $this->ListaContactosGerente();
    }

    public function BuscarContactoProveedor(Request $request)
    {        
        $this->nombre = $request->nombre;
        return $this->ListaContactosProveedores();
    }
}
