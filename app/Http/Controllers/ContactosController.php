<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contactos;
use App\Gerente;
use App\Proveedor;
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
   //ELIMINAR CLIENTES Y PROVEEDORES
    
    public function destroy($id)
    {
        $contacto = Contactos::find($id);
        $contacto->delete();

    }

    public $nombre;
    public function ListaContactosGerente($id)
    {
        
        $nombre = $this->nombre;
        #echo($this->nombre);
        $query= Contactos::select('contactos.*','proveedors.id','proveedors.nombre','proveedors.apellido_paterno', 
        'proveedors.apellido_materno','proveedors.telefono','proveedors.direccion','proveedors.user_id','users.status')
        ->join('proveedors','proveedors.id','contactos.proveedor_id')
        ->join('users','users.id','proveedors.user_id')
        ->where('contactos.gerente_id','=',$id)
        ->where('users.status','=',0)
        ->get();
        return $query;
    }


    public function ListaContactosProveedores($id)
    {
       
        $nombre = $this->nombre;

        $query = Contactos::select('contactos.*','gerentes.id','gerentes.nombre','gerentes.apellido_paterno','gerentes.apellido_materno','gerentes.user_id','users.status')
        ->join('gerentes','gerentes.id','contactos.gerente_id')
        ->join('users','users.id','gerentes.user_id')
        ->where('contactos.proveedor_id','=',$id)

        ->where('users.status','=',0)
        ->get();
        return $query;
    }

    
    public function buscarNombreContactosDelGerente(Request $request,$id){
        $nombre = $request->nombre;
        $query= Contactos::select('contactos.*','proveedors.id','proveedors.nombre','proveedors.apellido_paterno', 
        'proveedors.apellido_materno','proveedors.telefono','proveedors.direccion','proveedors.user_id','users.status')
        ->join('proveedors','proveedors.id','contactos.proveedor_id')
        ->join('users','users.id','proveedors.user_id')
        ->where('contactos.gerente_id','=',$id)
        ->where('proveedors.nombre','LIKE','%'.$nombre.'%')
        ->where('users.status','=',0)
        ->get();
        return $query;

    }
    public function buscarNombreContactosDelProveedor(Request $request,$id){
  
        $nombre = $request->nombre;

        $query = Contactos::select('contactos.*','gerentes.id','gerentes.nombre','gerentes.apellido_paterno','gerentes.apellido_materno','gerentes.user_id','users.status')
        ->join('gerentes','gerentes.id','contactos.gerente_id')
        ->join('users','users.id','gerentes.user_id')
        ->where('contactos.proveedor_id','=',$id)
        ->where('gerentes.nombre','LIKE','%'.$nombre.'%')
        ->where('users.status','=',0)
        ->get();
        return $query;
        
    }
}
