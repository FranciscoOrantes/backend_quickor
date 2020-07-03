<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;

class Negocios extends Model
{
    use Notifiable;
    use HasRoles;

    protected $fillable = [
        'nombre','direccion','telefono','rfc','gerente_id'
    ];

    public function getJWTIdentifier() {
        return $this->getKey();
        }
        public function getJWTCustomClaims() {
        return [];
        }
}
