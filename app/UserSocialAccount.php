<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSocialAccount extends Model
{
    protected $fillable = [
        'users_users_id',
        'provider',
        'provider_uid'
    ];

    //para las relaciones Eloquent
    public function user(){
        return $this->belongsTo('App\User');//una red social tiene varios usuarios dnd esta la foreing key
    }
}
