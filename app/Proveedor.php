<?php

namespace App;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;

class Proveedor extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre','apellido_paterno','apellido_materno','telefono','direccion','user_id'
    ];

    
    public function getJWTIdentifier() {
        return $this->getKey();
        }
        public function getJWTCustomClaims() {
        return [];
        }
       
}
