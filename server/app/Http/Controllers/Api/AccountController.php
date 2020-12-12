<?php

namespace App\Http\Controllers\Api;
use App\User;
use App\User_book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function accountindex(){
        $users = User::all();
        $response = array();
        $num = 0;
        foreach ($users as $user) {
            $response[$num]['user_id'] = $user->id;
            $response[$num]['user_name'] = $user->name;
            $response[$num]['user_email'] = $user->email;
            $num++;
        }
        return response()->json($response);
    }
    

}
