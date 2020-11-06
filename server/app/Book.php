<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function book(){
        return $this->hasMany('App\User_book');
    }
}
