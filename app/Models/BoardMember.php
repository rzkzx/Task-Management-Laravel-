<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardMember extends Model
{
    protected $table = 'board_members';
    protected $fillable = [
        'board_id','user_id'
    ];

    public function User(){
        return $this->belongsTo('App\User');
    }
}
