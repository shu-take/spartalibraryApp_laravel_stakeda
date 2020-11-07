<?php

namespace App\Http\Controllers;

use App\Book;
use App\User_book;
use App\Code_book;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class BookController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     $user = \Auth::user();
    //     return view('library/index', compact('user'));
    // }

    public function bookindex()
    {
        // $test = User_book::all->book;
        // var_dump($test->title);
        
        // $test = User_book::all()->book;
        // // var_dump($test->post->title);
        $user_id = Auth::id();
        $user_books = User_book::where('user_id', '=', $user_id)->get();
        // $lists = User_book::all();
        // $test = $lists->book;


        return view('library.bookindex', compact('user_books'));
    }

    public function bookshow($book_id)
    {
        
        $book = Book::find($book_id);
        echo $book->id;

        $code_books = Code_book::where('book_id', '=', $book_id)->get();

        // foreach ($code_books as $code_book)
        // {
        //     echo $code_book->code->title;
        // }

        return view('library.bookshow', compact('book','code_books'));
    }


    public function bookcreate(Request $request)
    {
        $isbn = $request->isbn;
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
                    return view('library.bookcreate',compact('book'));
                } else {
                    $book['error'] = "無効なISBNです";
                    return view('library.bookcreate',compact('book'));
                }
            } else {
                echo "もうある";
                $test = mb_strlen($book_all[0]['isbn']);
                echo $test;
                $book['title'] = $book_all[0]['title'];
                $book['contents'] = $book_all[0]['contents'];
                $book['isbn'] = $book_all[0]['isbn'];
                $book['img_url'] = null;
                $book['img_path'] = $book_all[0]['img_path'];
                $book['book_id'] = $book_all[0]['id'];
                $book['error'] = null;
                return view('library.bookcreate',compact('book'));
            }

        } else {
            $book['error'] = "ISBNが空です";
            return view('library.bookcreate',compact('book'));
        }
    }

    public function bookstore(Request $request)
    {
        $user_book = new User_book;
        $user_id = Auth::id();
        $img_path = $request->img_path;
        $img_url = $request->img_url;
        $book_id = $request->book_id;
        $user_book_check = User_book::where('user_id', '=', $user_id)->where('book_id', '=', $book_id)->get();

        if ($img_path) {
            if ($user_book_check != '[]') {
                return redirect('library');
            } else {
                $user_book->user_id = $user_id;
                $user_book->book_id = $book_id;
                $user_book->timestamps = true;
                $user_book->save();
                return redirect('library');
            }
        }
        
        if ($img_url) {
            $disk = Storage::disk('public');
            $book = new Book;

            $img =  file_get_contents($request->img_url);
            $img_dir = 'book';
            $img_head = 'storage/';
            $img_extension = '.jpg';
            $img_filename = $request->isbn.$img_extension;
            $imgfile = sprintf('%s/%s', $img_dir, $img_filename);
            $disk->put($imgfile, $img);
            $img_path = $img_head.$imgfile;

            $book->title = $request->title;
            $book->contents = $request->contents;
            $book->isbn = $request->isbn;
            $book->img_path = $img_path;
            $book->timestamps = false;
            $book->save();

            $book_id = Book::where('isbn', '=', $book->isbn)->get('id');
            $user_book->user_id = $user_id;
            $user_book->book_id = $book_id[0]['id'];;
            $user_book->timestamps = true;
            $user_book->save();

            return redirect('library');
        }

        // $disk = Storage::disk('public');
        // $book = new Book; 

        // $img =  file_get_contents($request->img_url);
        // $img_dir = 'book';
        // $img_head = 'storage/';
        // $img_extension = '.jpg';
        // $img_filename = $request->isbn.$img_extension;
        // $imgfile = sprintf('%s/%s', $img_dir, $img_filename);
        // $disk->put($imgfile, $img);
        // $img_path = $img_head.$imgfile;

        // $book->title = $request->title;
        // $book->contents = $request->contents;
        // $book->isbn = $request->isbn;
        // $book->img_path = $img_path;
        // $book->img_path = $img_path;
        // $book->timestamps = false;
        
        // $book->save();

        // return redirect('library');
    }

}
