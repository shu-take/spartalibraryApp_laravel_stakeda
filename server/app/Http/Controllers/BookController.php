<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;



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
        return view('library.bookindex');
    }
    public function bookcreate(Request $request)
    {
        $isbn = $request->isbn;
        if (!empty($isbn)) {
            $url = 'https://www.googleapis.com/books/v1/volumes?q=isbn:' . $isbn;
            $client = new Client();
            $response = $client->request("GET", $url);
            $body = $response->getBody();
            $bodyArray = json_decode($body, true);
            if ($bodyArray['totalItems'] != 0) {
                $book['title'] = $bodyArray['items'][0]['volumeInfo']['title'];
                $book['contents'] = $bodyArray['items'][0]['volumeInfo']['description'];
                $book['isbn'] = $bodyArray['items'][0]['volumeInfo']['industryIdentifiers'][0]['identifier'];
                $book['img_url'] = $bodyArray['items'][0]['volumeInfo']["imageLinks"]["thumbnail"];
                $book['error'] = null;
                return view('library.bookcreate',compact('book'));
            } else {
                $book['error'] = "無効なISBNです";
                return view('library.bookcreate',compact('book'));
            }
        } else {
            $book['error'] = "ISBNが空です";
            return view('library.bookcreate',compact('book'));
        }
    }

    public function bookstore(Request $request)
    {
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
        $book->img_path = $img_path;
        $book->timestamps = false;
        
        $book->save();

        return redirect('library');
    }

}
