<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;
class firebaseTokens extends Model
{
    use Notifiable;
    use HasRoles;
    protected $fillable = [
        'user_id','token_firebase'
    ];
    public function getJWTIdentifier() {
        return $this->getKey();
        }
        public function getJWTCustomClaims() {
        return [];
        }
       
}
