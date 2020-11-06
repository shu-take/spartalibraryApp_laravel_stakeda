<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_book extends Model
{
    public function book(){
        return $this->belongsTo('App\Book');
    }
}
