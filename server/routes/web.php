<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/library', 'LibraryController@index')->name('index');
Route::get('/library', 'BookController@bookindex')->name('bookindex');
// Route::get('/library/create', 'LibraryController@create')->name('create');
// Route::get('/library/confirm', 'LibraryController@confirm')->name('confirm');
Route::post('library/book/create', 'BookController@bookcreate')->name('bookcreate');
Route::post('library/book/store', 'BookController@bookstore')->name('bookstore');
Route::get('/library/code', 'CodeController@codeindex')->name('codeindex');
Route::post('/library/code/create', 'CodeController@codecreate')->name('codecreate');
Route::get('/library/code/show/{user_id}', 'CodeController@codeshow')->name('codeshow');

// Route::post('/library', 'LibraryController@store');
// Route::group(['middleware' => 'auth'], function() {
//     Route::resource('library', 'LibraryController');
// });

Route::get('/', function () {
    return view('auth.login');
});

// Route::resource('library', 'LibraryController');
