<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardList extends Model
{
    protected $table = 'board_lists';
    protected $fillable = [
        'board_id','order','name'
    ];

    public function board(){
        return $this->belongsTo('App\Models\Board');
    }

    public function cards(){
        return $this->hasMany('App\Models\Card');
    }
}
