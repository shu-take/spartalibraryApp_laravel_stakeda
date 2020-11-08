<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    public function code_book(){
        return $this->hasOne('App\Code_book');
    }
}
