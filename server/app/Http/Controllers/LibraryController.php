<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Client;

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
            // $request = $_GET["isbn"];

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
            //dd($items);
        }

        $gist = "https://gist.github.com/shu-take/7993f1004accc5716a9d1e30377d255b.js";
        $test = "echo 'hello';";
        $data = [
            'items' => $items,
            'keyword' => $request,
            'gist' => $gist,
            'test' => $test,
        ];

        return view('library/index', $data);
    }
}
