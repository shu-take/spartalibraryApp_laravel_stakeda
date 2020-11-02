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
Route::get('/library', 'LibraryController@index')->name('index');
Route::get('/library/create', 'LibraryController@create')->name('create');
Route::get('/library/store', 'LibraryController@store')->name('store');
Route::post('library/store', 'LibraryController@store')->name('store');
// Route::post('/library', 'LibraryController@store');
// Route::group(['middleware' => 'auth'], function() {
//     Route::resource('library', 'LibraryController');
// });

Route::get('/', function () {
    return view('auth.login');
});

// Route::resource('library', 'LibraryController');
