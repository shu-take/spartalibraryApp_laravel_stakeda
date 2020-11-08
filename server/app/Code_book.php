<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Code_book extends Model
{
    public function code(){
        return $this->belongsTo('App\Code');
    }

    public function book(){
        return $this->belongsTo('App\Book');
    }
}
