<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;
class notificaciones extends Model
{
    use Notifiable;
    use HasRoles;
    protected $fillable = [
        'user_id','pedido','url_producto','status','total'
    ];
    public function getJWTIdentifier() {
        return $this->getKey();
        }
        public function getJWTCustomClaims() {
        return [];
        }
}
