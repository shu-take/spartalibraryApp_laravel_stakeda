<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Code;

class CodeController extends Controller
{
    function codeindex()
    {
        return view('library.codeindex');
    }
    function codecreate(Request $request)
    {
        $code = $request->code;
        return view('library.codecreate', compact('code'));
    }
}
