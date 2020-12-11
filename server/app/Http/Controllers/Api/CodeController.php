<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Code;

class CodeController extends Controller
{
    public function codeindex($user_id)
    {
        $codes = Code::where('user_id', '=', $user_id)->get();
        $response = array();
        $num = 0;
        foreach ($codes as $code) {
            $response[$num]['code_id'] = $code->id;
            $response[$num]['code_title'] = $code->title;
            $response[$num]['code_contents'] = $code->contents;
            $response[$num]['code'] = $code->code;
            $num++;
        }
        return response()->json($response);
    }
}
