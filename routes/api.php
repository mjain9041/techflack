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
Route::get('users/edit/{id}', 'UserController@edit');
Route::get('users/{page?}/{search?}', 'UserController@index');
Route::delete('users/delete/{id}', 'UserController@destroy');
Route::post('users/update', 'UserController@update');
Route::post('users/store', 'UserController@store');

