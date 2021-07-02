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

Route::group([
    'middleware' => 'api',
], function ($router) {

    Route::group([
        'prefix' => 'auth'
    ], function ($router) {
        Route::post('login', '\App\Http\Controllers\Auth\AuthController@login')->name('login');
        Route::post('logout', '\App\Http\Controllers\Auth\AuthController@logout');
        Route::post('refresh', '\App\Http\Controllers\Auth\AuthController@refresh');
        Route::post('me', '\App\Http\Controllers\Auth\AuthController@me');
        Route::post('signup', '\App\Http\Controllers\Auth\AuthController@signup');
    });

    Route::group(['middleware' => ['jwt.auth']], function() {
        Route::apiResource('users', '\App\Http\Controllers\Users\UserController');
    });
});
