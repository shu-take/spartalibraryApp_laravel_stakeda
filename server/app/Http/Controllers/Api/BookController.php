<?php

namespace App\Http\Controllers\Api;

use App\User_book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function bookindex($user_id)
    {
        $user_books = User_book::where('user_id', '=', $user_id)->get();
        $response = array();
        $num = 0;
        foreach ($user_books as $user_book) {
            $response[$num]['book_id'] = $user_book->book->id;
            $response[$num]['book_title'] = $user_book->book->title;
            $response[$num]['book_contents'] = $user_book->book->contents;
            $response[$num]['book_isbn'] = $user_book->book->isbn;
            $response[$num]['book_img_path'] = $user_book->book->img_path;
            $num++;
        }
        return response()->json($response);
    }
}
