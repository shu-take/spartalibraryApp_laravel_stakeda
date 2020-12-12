<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/library/account/index', 'Api\AccountController@accountindex');

Route::get('/library/book/index/{user_id}', 'Api\BookController@bookindex');
Route::get('/library/code/index/{user_id}', 'Api\CodeController@codeindex');