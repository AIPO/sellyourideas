<?php

use Illuminate\Http\Request;

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
//List ideas
Route::get('ideas','IdeaController@index');
//List single idea
Route::get('idea/{id}','IdeaController@show');
//Create new idea
Route::post('idea', 'IdeaController@store');
//Update idea
Route::put('idea', 'IdeaController@store');
//Delete idea
Route::delete('idea/{id}','IdeaController@destroy');

