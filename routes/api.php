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
Route::get('ideas','IdeasController@index');
//List single idea
Route::get('ideas/{id}','IdeasController@show');
//Create new idea
Route::post('idea', 'IdeaController@store');

