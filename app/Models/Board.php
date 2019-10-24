<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $table = 'boards';
    protected $fillable = [
        'creator_id','name'
    ];

    public function boardList(){
        return $this->hasMany('App\Models\BoardList');
    }
}
