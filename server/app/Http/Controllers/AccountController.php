<?php

namespace App\Http\Controllers;
use App\User;
use App\Book;
use App\Code;
use App\User_book;
use App\Code_book;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function accountindex(){
        $users = User::all();
        return view('library.accountindex',compact('users'));
    }

    public function accountbookindex($user_id)
    {
        $user = User::find($user_id);
        $user_books = User_book::where('user_id', '=', $user_id)->get();
        $user_name = $user['name'];
        return view('library.accountbookindex',compact('user_id','user_name', 'user_books'));
    }

    public function accountcodeindex($user_id)
    {
        $user = User::find($user_id);
        $codes = Code::where('user_id', '=', $user_id)->get();
        $user_name = $user['name'];
        return view('library.accountcodeindex',compact('user_id','user_name', 'codes'));
    }

    public function accountbookshow($user_id, $book_id)
    {
        $user = User::find($user_id);
        $book = Book::find($book_id);
        $user_name = $user['name'];
        return view('library.accountbookshow', compact('user_id', 'user_name','book'));
    }

    public function accountcodeshow($user_id, $code_id)
    {
        $user = User::find($user_id);
        $code = Code::find($code_id);
        $user_name = $user['name'];
        return view('library.accountcodeshow', compact('user_id', 'user_name','code'));
    }



}