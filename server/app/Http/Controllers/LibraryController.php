<?php

namespace App\Http\Controllers;

use App\Library;
use App\Book;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;


class LibraryController extends Controller
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

    public function index()
    {
        $data = []; 
        $items = null;
        $request = "9784798060996";

        if (!empty($request))
        {
            // 検索キーワードあり

            // 日本語で検索するためにURLエンコードする
            // $title = urlencode($request);

            // APIを発行するURLを生成
            $url = 'https://www.googleapis.com/books/v1/volumes?q=isbn:' . $request;
    
            $client = new Client();

            // GETでリクエスト実行
            $response = $client->request("GET", $url);
    
            $body = $response->getBody();
            
            // レスポンスのJSON形式を連想配列に変換
            $bodyArray = json_decode($body, true);
            // 書籍情報部分を取得
            $items = $bodyArray['items'];

            // レスポンスの中身を見る
            // dd($items);
        }

        $data = [
            'items' => $items,
            'keyword' => $request,
        ];

        return view('library/index', $data);
    }

    public function create()
    {
        return view('library.create');
    }

    public function confirm(Request $request)
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
                return view('library.confirm',compact('book'));
            }
            $book['error'] = "無効なisbnです";
            return view('library.confirm',compact('book'));    
        } else {
            $book['error'] = "Isbnが空です";
            return view('library.confrim',compact('book'));
        }


        // return view('library.store');
    }
    public function store(Request $request)
    {
        $disk = Storage::disk('public');
        $book = new Book; 

        // $title = $request->title;
        // $contents = $request->contents;
        // $isbn = $request->isbn;

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

        $book->save();
        
    }
}