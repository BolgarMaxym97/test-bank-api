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
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/cards/{user}', 'CardsController@getForUser')->name('user.cards');
    Route::post('/cards', 'CardsController@create')->name('card.create');
    Route::put('/cards/{card}', 'CardsController@update')->name('card.update');
    Route::delete('/cards/{card}', 'CardsController@delete')->name('card.delete');
});
