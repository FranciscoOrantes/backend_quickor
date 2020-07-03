<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gerente extends Model
{
    protected $fillable = [
        'nombre','apellido_paterno','apellido_materno','user_id'
        
    ];
}
