<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    public function code(){
        return $this->hasMany('App\Code_book');
    }
}
