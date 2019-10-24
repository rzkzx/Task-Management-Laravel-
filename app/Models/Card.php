<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'cards';
    protected $fillable = [
        'list_id','order','task'
    ];

    public function boardList(){
        return $this->belongsTo('App\Models\BoardList');
    }
}
