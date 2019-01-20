<?php

use Illuminate\Http\Request;
//use App\Http\Controllers\Auth;

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

Route::post('/auth', 'Auth\LoginController@login');

Route::resource('books', 'BookController', [
  'except' => [
    'index', 
    'show'
  ]
])->middleware('auth:api');

Route::resource('books', 'BookController', [
  'only' => [
    'index', 
    'show'
  ]
]);
