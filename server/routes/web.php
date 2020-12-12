<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });



Auth::routes();

Route::get('/library', 'BookController@bookindex')->name('bookindex');

Route::get('/library/book/show/{book_id}', 'BookController@bookshow')->name('bookshow');
Route::get('/library/book/codeshow/{user_id}', 'BookController@bookcodeshow')->name('bookcodeshow');

Route::post('library/book/create', 'BookController@bookcreate')->name('bookcreate');
Route::post('library/book/store', 'BookController@bookstore')->name('bookstore');
Route::post('library/book/delete', 'BookController@bookdestroy')->name('bookdestroy');
Route::get('/library/code', 'CodeController@codeindex')->name('codeindex');
Route::post('/library/code/create', 'CodeController@codecreate')->name('codecreate');
Route::get('/library/code/show/{user_id}', 'CodeController@codeshow')->name('codeshow');
Route::post('library/code/delete', 'CodeController@codedestroy')->name('codedestroy');
Route::get('/library/account', 'AccountController@accountindex')->name('accountindex');
Route::get('/library/account/bookindex/{user_id}', 'AccountController@accountbookindex')->name('accountbookindex');
Route::get('/library/account/codeindex/{user_id}', 'AccountController@accountcodeindex')->name('accountcodeindex');
Route::get('/library/account/bookshow/{user_id}/{book_id}','AccountController@accountbookshow')->name('accountbookshow');
Route::get('/library/account/codeshow/{user_id}/{code_id}','AccountController@accountcodeshow')->name('accountcodeshow');

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
