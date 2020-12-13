<?php

namespace App\Http\Controllers\Api;

use App\User_book;
use App\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

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

    public function bookcreate($isbn)
    {
        $book_isbn = Book::where('isbn', '=', $isbn)->get('isbn');
        $book_all = Book::where('isbn', '=', $isbn)->get();
        if (!empty($isbn)) {
            if ($book_isbn == '[]'){
                $url = 'https://www.googleapis.com/books/v1/volumes?q=isbn:' . $isbn;
                $client = new Client();
                $response = $client->request("GET", $url);
                $body = $response->getBody();
                $bodyArray = json_decode($body, true);
                $isbn_check = mb_strlen($isbn);
                if ($bodyArray['totalItems'] != 0 && $isbn_check == 13) {
                    $book['title'] = $bodyArray['items'][0]['volumeInfo']['title'];
                    $book['contents'] = $bodyArray['items'][0]['volumeInfo']['description'];
                    $book['isbn'] = $bodyArray['items'][0]['volumeInfo']['industryIdentifiers'][0]['identifier'];
                    $book['img_url'] = $bodyArray['items'][0]['volumeInfo']["imageLinks"]["thumbnail"];
                    $book['img_path'] = null;
                    $book['book_id'] = null;
                    $book['error'] = null;
                    if (mb_strlen($book['isbn']) == 10) {
                        $book['isbn'] = $bodyArray['items'][0]['volumeInfo']['industryIdentifiers'][1]['identifier'];
                    }
                    // return view('library.bookcreate',compact('book'));
                    return response()->json($book);
                } else {
                    $book['title'] = null;
                    $book['contents'] = null;
                    $book['isbn'] = null;
                    $book['img_url'] = null;
                    $book['img_path'] = null;
                    $book['book_id'] = null;
                    $book['error'] = "無効なISBNです";
                    // return view('library.bookcreate',compact('book'));
                    return response()->json($book);
                }
            } else {
                $book['title'] = $book_all[0]['title'];
                $book['contents'] = $book_all[0]['contents'];
                $book['isbn'] = $book_all[0]['isbn'];
                $book['img_url'] = null;
                $book['img_path'] = $book_all[0]['img_path'];
                $book['book_id'] = $book_all[0]['id'];
                $book['error'] = null;
                // return view('library.bookcreate',compact('book'));
                return response()->json($book);

            }

        } else {
            $book['title'] = null;
            $book['contents'] = null;
            $book['isbn'] = null;
            $book['img_url'] = null;
            $book['img_path'] = null;
            $book['book_id'] = null;
            $book['error'] = "ISBNが空です";
            // return view('library.bookcreate',compact('book'));
            return response()->json($book);
        }
    }
    
    public function bookstore($user_id, $book_id, $book_title, $book_contents, $book_isbn, $img_path, $img_url)
    {
        $user_book = new User_book;
        // $user_id = Auth::id();
        // $img_path = $request->img_path;
        // $img_url = $request->img_url;
        // $book_id = $request->book_id;
        $user_book_check = User_book::where('user_id', '=', $user_id)->where('book_id', '=', $book_id)->get();

        if ($img_path) {
            if ($user_book_check != '[]') {
                // return redirect('library');
            } else {
                $user_book->user_id = $user_id;
                $user_book->book_id = $book_id;
                $user_book->timestamps = true;
                $user_book->save();
                // return redirect('library');
            }
        }
        
        if ($img_url) {
            $disk = Storage::disk('public');
            $book = new Book;

            $img =  file_get_contents($img_url);
            $img_dir = 'book';
            $img_head = 'storage/';
            $img_extension = '.jpg';
            $img_filename = $book_isbn.$img_extension;
            $imgfile = sprintf('%s/%s', $img_dir, $img_filename);
            $disk->put($imgfile, $img);
            $img_path = $img_head.$imgfile;

            $book->title = $book_title;
            $book->contents = $book_contents;
            $book->isbn = $book_isbn;
            $book->img_path = $img_path;
            $book->timestamps = false;
            $book->save();

            $book_id = Book::where('isbn', '=', $book->isbn)->get('id');
            $user_book->user_id = $user_id;
            $user_book->book_id = $book_id[0]['id'];;
            $user_book->timestamps = true;
            $user_book->save();

            // return redirect('library');
        }
    }

}
