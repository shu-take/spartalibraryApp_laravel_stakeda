<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CodeRequest;
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

        return view('library.codeindex', compact('codes','user_books'));
    }
    public function codecreate(CodeRequest $request)
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
    public function codeshow($code_id)
    {
        $code = Code::find($code_id);
        // $code_book = $code->code_book;
        // $book = $code_book->book;
        // dd($code,$code_book, $book);
        // $code_book = $code->code;
        // $code_book = Code_book::where('code_id', '=', $code->id)->get();
        return view('library.codeshow', compact('code'));
    }

    public function codedestroy(Request $request)
    {
        $code_id = $request['code_id'];
        $code = Code::find($code_id);
        $code_book = Code_book::where('code_id', '=', $code_id);
        $code->delete();
        $code_book->delete();
        return redirect('library/code');
    }

}
