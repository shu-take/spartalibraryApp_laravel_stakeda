<?php

namespace App\Http\Controllers\Api;
use App\User;
use App\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function accountshow(Request $request)
    {
        $email = $request->email;
        // $password =  $request->password;
        // $user = User::find($email);
        

        // return response()->json(['name' => $user->name]);
        return response()->json(['email' => $email]);

    }

    public function test()
    {
        // $user = User::find($request->email);
        $email = "st@test.com";
        $user = User::where('email', '=', $email)->get();
        // $name = $user['name'];
        // $email = $user['email'];
        // return $user;
        // $test = $request->email;
        return response()->json($user);
        
        // return response()->json(['name' => 'test', 'email' => 'test']);
    }

    public function test2()
    {
        $book_id = 7;
        $book = Book::find($book_id);
        // return $book->img_path;
        // $book_json = json_decode($book, JSON_UNESCAPED_UNICODE);
        return response()->json($book);
    }

    

}
