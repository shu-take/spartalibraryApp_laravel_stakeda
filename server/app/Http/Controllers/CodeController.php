<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Code;
use App\Book;
use App\User_book;
use App\Code_book;
use Illuminate\Support\Facades\Auth;

class CodeController extends Controller
{
    public function codeindex()
    {
        $user_id = Auth::id();
        $codes = Code::where('user_id', '=', $user_id)->get();
        $user_books = User_book::where('user_id', '=', $user_id)->get();
        // $code_books = Code_book::where('user_id', '=', $user_id)->get();


        return view('library.codeindex', compact('codes','user_books'));
    }
    public function codecreate(Request $request)
    {
        $code = new Code;
        $code->title = $request->title;
        $code->contents = $request->contents;
        $code->code = $request->code;
        $code->user_id = Auth::id(); 
        $code->timestamps = true;
        $code->save();

        $code_book = new Code_book;
        $code_book->code_id = $code->id;
        $code_book->book_id = $request->book_id;
        $code_book->timestamps = true;
        $code_book->save();

        return redirect('library/code');
    }
    public function codeshow($user_id)
    {
        $code = Code::find($user_id);
        return view('library.codeshow', compact('code'));
    }

}
