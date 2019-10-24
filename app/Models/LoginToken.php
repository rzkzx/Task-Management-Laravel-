<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginToken extends Model
{
    protected $table = 'login_tokens';
    protected $fillable = ['token','user_id'];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
