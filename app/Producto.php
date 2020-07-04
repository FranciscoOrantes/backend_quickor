<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;

class Producto extends Model
{
    use Notifiable;
    use HasRoles;

    protected $fillable = [
        'nombre', 'presentacion', 'cantidad_presentacion', 'tamano_producto', 'logo', 'precio', 'marca_id', 'proveedor_id'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
