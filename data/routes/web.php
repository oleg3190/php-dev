<?php

use Illuminate\Support\Facades\Route;
use App\Events\Message as Chat;
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



Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::post('/messages', 'HomeController@index_infinite');

Route::group([
    'middleware'=>'auth',
    'prefix' => 'cabinet',
    'namespace'=>'Cabinet',
    'as' => 'cabinet',
], function () {
    Route::group([
        'prefix' => 'message',
        'as' => 'message',
    ], function () {
        Route::post('/store', 'MessageController@store');
        Route::post('/destroy/{message}', 'MessageController@destroy');
    });
});

