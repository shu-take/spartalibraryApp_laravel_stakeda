<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Code;
use Illuminate\Support\Facades\Auth;

class CodeController extends Controller
{
    public function codeindex()
    {
        $user_id = Auth::id();
        $codes = Code::where('user_id', '=', $user_id)->get();
        return view('library.codeindex', compact('codes'));
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
        return redirect('library/code');
    }
    public function codeshow($user_id)
    {
        $code = Code::find($user_id);
        return view('library.codeshow', compact('code'));
    }

}
