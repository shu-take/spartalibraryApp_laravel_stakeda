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

// Route::get('/test', function(){
//     $user = App\User::find(12);
//     $token = $user->createToken('token')->accessToken;
//     return response()->json(['token' => $token]);
// });

Route::post('/library/account/show', 'AccountController@accounshow')->name('accountshow');
// Route::post('/test', 'Api\AccountController@test');

Route::get('/test', 'Api\AccountController@test');
Route::get('/test2', 'Api\AccountController@test2');