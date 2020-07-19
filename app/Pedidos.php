<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class Pedidos extends Model
{
    protected $fillable = [
        'producto_id', 'proveedor_id','gerente_id','status','status_pago','fecha','num_pedido','cantidad'
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
