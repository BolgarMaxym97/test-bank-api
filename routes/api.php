<?php

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

Route::get('/', function () {
   return 'Silence is golden';
});

// without token
Route::post('/register', 'AuthController@create');
Route::post('/login', 'AuthController@login');

// with token
Route::group([], function () {

});
